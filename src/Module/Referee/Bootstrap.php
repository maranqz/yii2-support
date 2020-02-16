<?php

namespace SSupport\Module\Referee;

use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierInterface;
use SSupport\Component\Referee\Gateway\Repository\GetRefereeForTicketInterface;
use SSupport\Component\Referee\Gateway\Repository\RefereeUserRepositoryInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestReferee;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInputInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessage;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInputInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Gateway\Uploader\AttachmentUploadListener;
use SSupport\Module\Core\Module as CoreModule;
use SSupport\Module\Core\Resource\Widget\Messages\Widget\HeaderWidget as CoreHeaderWidget;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Referee\Gateway\Notification\Notifier;
use SSupport\Module\Referee\Gateway\Repository\RefereeUserRepository;
use SSupport\Module\Referee\Gateway\Repository\SimpleGetRefereeForTicket;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettings;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\Resource\Widget\Messages\Widget\HeaderWidget as RefereeHeaderWidget;
use SSupport\Module\Referee\UseCase\Customer\RequestRefereeInputForm;
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
    use ContainerAwareTrait;

    /** @var CoreModule */
    protected $coreModule;

    /** @var Module */
    protected $module;

    /** {@inheritdoc} */
    public function bootstrap($app)
    {
        $this->checkCoreModule($app);

        if (!$this->initModule($app)) {
            return;
        }
        $this->initEntity();
        $this->initGateway();
        $this->initUseCase();
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
        $this->setSingleton(NotifierInterface::class, Notifier::class);
        $this->setSingleton(GetRefereeForTicketInterface::class, SimpleGetRefereeForTicket::class);
        $this->setSingleton(RefereeUserRepositoryInterface::class, RefereeUserRepository::class);
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

        $this->initForm();
        $this->initWidget();
    }

    protected function initForm()
    {
        $this->setSingleton(RequestRefereeInputInterface::class, RequestRefereeInputForm::class);
        $this->setSingleton(SendMessageInputInterface::class, SendMessageInputForm::class);
    }

    protected function initWidget()
    {
        $this->set(CoreHeaderWidget::class, RefereeHeaderWidget::class);
    }

    protected function initTranslations(Application $app)
    {
        if (!isset($app->get('i18n')->translations['ssupport*'])) {
            $app->get('i18n')->translations['ssupport*'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__.'/Resource/i18n',
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
            throw new InvalidConfigException('You should use '.CoreModule::$name);
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
