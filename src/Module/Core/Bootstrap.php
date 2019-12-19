<?php

namespace SSupport\Module\Core;

use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Factory\FactoryInterface;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetTicketDefaultAgentsInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicket;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Entity\Attachment;
use SSupport\Module\Core\Entity\Message;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Factory\Factory;
use SSupport\Module\Core\Factory\Message\MessageFactory;
use SSupport\Module\Core\Gateway\Notification\Notifier;
use SSupport\Module\Core\Gateway\Repository\TicketRepository;
use SSupport\Module\Core\Gateway\Repository\User\UserRepository;
use SSupport\Module\Core\UseCase\Customer\SendMessageInputForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\FileHelper;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;
use yii\web\GroupUrlRule;

class Bootstrap implements BootstrapInterface
{
    use ContainerAwareTrait;

    /** {@inheritdoc} */
    public function bootstrap($app)
    {
        $this->initContainer();
        $this->initTranslations($app);

        if ($app instanceof WebApplication) {
            $this->initWebApplication($app);
        }
    }

    protected function initContainer()
    {
        try {
            $this->checkRequiredClass();
            $this->initDefaultFilesystem();
            $this->initEntity();
            $this->initFactory();
            $this->initGateway();
            $this->initUseCase();
            $this->initForm();
        } catch (Exception $e) {
            die($e);
        }
    }

    protected function checkRequiredClass()
    {
        $this->checkDIClass(UserInterface::class);
        $this->checkDIClass(EventDispatcherInterface::class);
    }

    protected function initEntity()
    {
        $di = $this->getDi();

        $di->set(TicketInterface::class, Ticket::class);
        $di->set(MessageInterface::class, Message::class);
        $di->set(AttachmentInterface::class, Attachment::class);
    }

    protected function initFactory()
    {
        $di = $this->getDi();

        $di->set(FactoryInterface::class.'.Ticket', Factory::class, [
            $this->getDIClass(TicketInterface::class),
        ]);

        $di->set(MessageFactoryInterface::class, MessageFactory::class);
    }

    protected function initGateway()
    {
        $this->initRepository();

        $di = $this->getDi();
        $di->set(NotifierInterface::class, Notifier::class);
    }

    protected function initRepository()
    {
        $di = $this->getDi();

        $this->checkDIClass(GetTicketDefaultAgentsInterface::class);

        $di->set(UserRepositoryInterface::class, UserRepository::class, [
            $this->getDIClass(UserInterface::class),
        ]);

        $di->set(TicketRepositoryInterface::class, TicketRepository::class);
        //$di->set(AttachmentRepositoryInterface::class, AttachmentRepository::class);
    }

    protected function initUseCase()
    {
        $di = $this->getDi();

        $di->set(CreateTicket::class, CreateTicket::class, [
            4 => $di->get(FactoryInterface::class.'.Ticket'),
        ]);

        $di->set(SendMessageInterface::class, SendMessage::class);
    }

    protected function initForm()
    {
        $di = $this->getDi();

        $di->set(SendMessageInputInterface::class, SendMessageInputForm::class);
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

    protected function initDefaultFilesystem()
    {
        $di = $this->getDi();
        if (!$di->has(FilesystemInterface::class)) {
            $di->set(FilesystemInterface::class, function () {
                $path = Yii::getAlias('@webroot/support/attachment');
                FileHelper::createDirectory($path);

                $adapter = new Local($path);

                return new Filesystem($adapter);
            });
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
        $config = [
            'class' => GroupUrlRule::class,
            'prefix' => $module->prefix,
            'rules' => $module->routes,
        ];

        if (Module::DEFAULT_NAME !== $module->prefix) {
            $config['routePrefix'] = Module::DEFAULT_NAME;
        }

        $rule = Yii::createObject($config);
        $app->getUrlManager()->addRules([$rule], false);
    }

    protected function initView(WebApplication $app)
    {
        $app->getModule(Module::$name)->setViewPath('@SSupport/Module/Core/Resource/views');
    }
}
