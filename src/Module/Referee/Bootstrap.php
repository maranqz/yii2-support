<?php

namespace SSupport\Module\Referee;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromAgentInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromCustomerInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierListenerInterface;
use SSupport\Component\Referee\Gateway\Repository\User\GetRefereeForTicketInterface;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestReferee;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInputInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInterface;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequest;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequestInputInterface;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequestInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessage;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInputInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Gateway\Notification\NotifierListener as CoreRefereeNotifierListener;
use SSupport\Module\Core\Gateway\Uploader\AttachmentUploadListener;
use SSupport\Module\Core\Module as CoreModule;
use SSupport\Module\Core\Resource\Widget\Messages\Widget\HeaderWidget as CoreHeaderWidget;
use SSupport\Module\Core\Utils\BootstrapTrait;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Referee\Gateway\Notification\NotifierListener as RefereeNotifierListener;
use SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee\GetTimeoutRequestRefereeInterface;
use SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee\TicketGetTimeoutRequestReferee;
use SSupport\Module\Referee\Gateway\Repository\User\GetRecipientsFromAgent;
use SSupport\Module\Referee\Gateway\Repository\User\GetRecipientsFromCustomer;
use SSupport\Module\Referee\Gateway\Repository\User\SimpleGetRefereeForTicket;
use SSupport\Module\Referee\Gateway\Repository\User\UserRepository;
use SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus\TimeoutRequestRefereeStatus;
use SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus\TimeoutRequestRefereeStatusInterface;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettings;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\Resource\Widget\Messages\Widget\HeaderWidget as RefereeHeaderWidget;
use SSupport\Module\Referee\UseCase\Customer\RequestRefereeInputForm;
use SSupport\Module\Referee\UseCase\Customer\SetTimeoutRequestInputForm;
use SSupport\Module\Referee\UseCase\Referee\SendMessageInputForm;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;

class Bootstrap implements BootstrapInterface
{
    use BootstrapTrait;
    use ContainerAwareTrait;

    /**
     * @var CoreModule
     */
    protected $coreModule;

    /**
     * @var Module
     */
    protected $module;

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        $this->checkCoreModule($app);

        if (!$this->initModule($app)) {
            return;
        }
        $this->initEntity();
        $this->initGateway();
        $this->initUseCase();
        $this->initListeners($this->getModule()->defaultListeners);
        $this->initTranslations($app);

        if ($app instanceof WebApplication) {
            $this->initWebApplication($app);
        }
    }

    protected function initEntity()
    {
        $this->setSingleton(RefereeInterface::class, UserInterface::class);
    }

    protected function initGateway()
    {
        $this->initRepository();
        $this->initNotifier();

        $this->setSingleton(TimeoutRequestRefereeStatusInterface::class, TimeoutRequestRefereeStatus::class);
    }

    protected function initRepository()
    {
        $this->setSingleton(
            GetRecipientsFromCustomerInterface::class,
            GetRecipientsFromCustomer::class,
            [],
            true
        );
        $this->setSingleton(
            GetRecipientsFromAgentInterface::class,
            GetRecipientsFromAgent::class,
            [],
            true
        );

        $this->setSingleton(GetRefereeForTicketInterface::class, SimpleGetRefereeForTicket::class);
        $this->setSingleton(UserRepositoryInterface::class, UserRepository::class);

        $this->setSingleton(GetTimeoutRequestRefereeInterface::class, TicketGetTimeoutRequestReferee::class);
    }

    protected function initNotifier()
    {
        $this->setSingleton(NotifierListenerInterface::class, RefereeNotifierListener::class, [
            3 => $this->getCoreModule()->emailFrom,
        ]);

        Yii::setAlias(
            RefereeNotifierListener::DEFAULT_PATH . 'sendMessageFromAgent',
            CoreRefereeNotifierListener::DEFAULT_PATH . 'sendMessageFromAgent'
        );
        Yii::setAlias(
            RefereeNotifierListener::DEFAULT_PATH . 'sendMessageFromCustomer',
            CoreRefereeNotifierListener::DEFAULT_PATH . 'sendMessageFromCustomer'
        );
    }

    protected function initUploader()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->make(EventDispatcherInterface::class);
        $uploadListener = $this->make(AttachmentUploadListener::class);

        foreach ($this->getModule()->uploaderListenerEvents as $event) {
            $dispatcher->addListener($event, $uploadListener);
        }
    }

    protected function initUseCase()
    {
        $this->setSingleton(RequestRefereeInterface::class, RequestReferee::class);
        $this->setSingleton(SendMessageInterface::class, SendMessage::class);
        $this->setSingleton(SetTimeoutRequestInterface::class, SetTimeoutRequest::class);

        $this->initForm();
        $this->initWidget();
    }

    protected function initForm()
    {
        $this->setSingleton(RequestRefereeInputInterface::class, RequestRefereeInputForm::class);
        $this->setSingleton(SendMessageInputInterface::class, SendMessageInputForm::class);
        $this->setSingleton(SetTimeoutRequestInputInterface::class, SetTimeoutRequestInputForm::class);
    }

    protected function initWidget()
    {
        $this->set(CoreHeaderWidget::class, RefereeHeaderWidget::class);
    }

    protected function initTranslations(Application $app)
    {
        if (!isset($app->get('i18n')->translations['ssupport_referee*'])) {
            $app->get('i18n')->translations['ssupport_referee*'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/Resource/i18n',
                'sourceLanguage' => 'en-US',
            ];
        }
    }

    protected function initWebApplication(WebApplication $app)
    {
        $this->initUrlRoute($app);

        $this->initView($app);
    }

    protected function initUrlRoute(WebApplication $app)
    {
        $module = $app->getModule(Module::$name);

        $prefix = $module->prefix;
        $config = [
            'class' => GroupUrlRule::class,
            'prefix' => $this->getPrefix($prefix),
            'routePrefix' => Module::$name,
            'rules' => $module->routes,
        ];

        $rule = Yii::createObject($config);
        $app->getUrlManager()->addRules([$rule], true);
    }

    protected function getPrefix($prefix)
    {
        if (!empty($prefix)) {
            return $prefix;
        }

        return $this->getCoreModule()->prefix;
    }

    protected function initView(WebApplication $app)
    {
        $app->getModule(Module::$name)->setViewPath('@SSupport/Module/Referee/Resource/views');

        $this->set(RefereeGridViewSettingsInterface::class, RefereeGridViewSettings::class);
    }

    protected function checkCoreModule(Application $app)
    {
        if (!$app->hasModule(CoreModule::$name)) {
            throw new InvalidConfigException('You should use ' . CoreModule::$name);
        }

        $this->coreModule = $app->getModule(CoreModule::$name);
    }

    protected function initModule(Application $app)
    {
        if ($app->hasModule(Module::$name)) {
            $module = $app->getModule(Module::$name);
            if ($module instanceof Module) {
                $this->module = $module;

                return true;
            }
        }

        return false;
    }

    protected function getModule()
    {
        return $this->module;
    }

    protected function getCoreModule()
    {
        return $this->coreModule;
    }
}
