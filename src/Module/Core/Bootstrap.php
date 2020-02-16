<?php

namespace SSupport\Module\Core;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
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
use SSupport\Component\Core\Gateway\Uploader\AttachmentPathGeneratorInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUpload;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadInterface;
use SSupport\Component\Core\Gateway\Uploader\DefaultAttachmentPathGenerator;
use SSupport\Component\Core\Gateway\Uploader\UploaderInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\SendMessage as AgentSendMessage;
use SSupport\Component\Core\UseCase\Agent\SendMessage\SendMessageInputInterface as AgentSendMessageInputInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\SendMessageInterface as AgentSendMessageInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicket;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage as CustomerSendMessage;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface as CustomerSendMessageInputInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInterface as CustomerSendMessageInterface;
use SSupport\Module\Core\Entity\Attachment;
use SSupport\Module\Core\Entity\Message;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Factory\Factory;
use SSupport\Module\Core\Factory\Message\MessageFactory;
use SSupport\Module\Core\Gateway\Filesystem\LocalUrlAdapter;
use SSupport\Module\Core\Gateway\Filesystem\UrlAdapterInterface;
use SSupport\Module\Core\Gateway\Notification\Notifier;
use SSupport\Module\Core\Gateway\Repository\TicketRepository;
use SSupport\Module\Core\Gateway\Repository\User\UserRepository;
use SSupport\Module\Core\Gateway\Uploader\AttachmentUploadListener;
use SSupport\Module\Core\Gateway\Uploader\Uploader;
use SSupport\Module\Core\Gateway\Uploader\UploadFileConverterAttachment;
use SSupport\Module\Core\Gateway\Uploader\UploadFileConverterAttachmentInterface;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettings;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewConfig;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewSettingsInterface;
use SSupport\Module\Core\UseCase\Agent\SendMessageInputForm as AgentSendMessageInputForm;
use SSupport\Module\Core\UseCase\Customer\SendMessageInputForm as CustomerSendMessageInputForm;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettings;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
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

    const LOCAL_ATTACHMENTS_DIRECTORY = '/support/attachment/';

    /** @var Module */
    protected $module;

    /** {@inheritdoc} */
    public function bootstrap($app)
    {
        if (!$this->initModule($app)) {
            return;
        }

        $this->checkRequiredClass();

        $this->initAliases();

        $this->initDefaultFilesystem();
        $this->initEntity();
        $this->initFactory();
        $this->initGateway();
        $this->initUseCase();
        $this->initForm();
        $this->initTranslations($app);

        if ($app instanceof WebApplication) {
            $this->initWebApplication($app);
        }
    }

    protected function checkRequiredClass()
    {
        $this->checkDIClass(UserInterface::class);
    }

    protected function initAliases()
    {
        $this->getModule()->setAliases([
            '@support' => __DIR__,
        ]);
    }

    protected function initEntity()
    {
        $this->setSingleton(TicketInterface::class, Ticket::class);
        $this->setSingleton(MessageInterface::class, Message::class);
        $this->setSingleton(AttachmentInterface::class, Attachment::class);
    }

    protected function initFactory()
    {
        $this->setSingleton(FactoryInterface::class.'.Ticket', Factory::class, [
            $this->getDIClass(TicketInterface::class),
        ]);

        $this->setSingleton(MessageFactoryInterface::class, MessageFactory::class);
    }

    protected function initGateway()
    {
        $this->initEvent();
        $this->initRepository();

        $this->setSingleton(NotifierInterface::class, Notifier::class);

        $this->setSingleton(
            AttachmentPathGeneratorInterface::class,
            DefaultAttachmentPathGenerator::class
        );

        $this->setSingleton(UrlAdapterInterface::class, LocalUrlAdapter::class, [
            $this->getModule()->attachmentWebPath,
        ]);

        $this->initUploader();
    }

    protected function initEvent()
    {
        $this->setSingleton(EventDispatcherInterface::class, EventDispatcher::class);
    }

    protected function initRepository()
    {
        $this->checkDIClass(GetTicketDefaultAgentsInterface::class);

        $this->setSingleton(UserRepositoryInterface::class, UserRepository::class, [
            $this->getDIClass(UserInterface::class),
        ]);

        $this->setSingleton(TicketRepositoryInterface::class, TicketRepository::class);
    }

    protected function initUploader()
    {
        $this->setSingleton(UploaderInterface::class, Uploader::class);
        $this->set(AttachmentUploadInterface::class, AttachmentUpload::class);
        $this->set(
            UploadFileConverterAttachmentInterface::class,
            UploadFileConverterAttachment::class
        );

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->make(EventDispatcherInterface::class);
        $uploadListener = $this->make(AttachmentUploadListener::class);

        foreach ($this->getModule()->uploaderListenerEvents as $event) {
            $dispatcher->addListener($event, $uploadListener);
        }
    }

    protected function initUseCase()
    {
        $this->setSingleton(CreateTicketInterface::class, CreateTicket::class, [
            4 => $this->make(FactoryInterface::class.'.Ticket'),
        ]);

        $this->setSingleton(CustomerSendMessageInterface::class, CustomerSendMessage::class);
        $this->setSingleton(AgentSendMessageInterface::class, AgentSendMessage::class);
    }

    protected function initForm()
    {
        $this->setSingleton(CustomerSendMessageInputInterface::class, CustomerSendMessageInputForm::class);
        $this->setSingleton(AgentSendMessageInputInterface::class, AgentSendMessageInputForm::class);

        $this->setSingleton(AttachmentUploadSettingsInterface::class, AttachmentUploadSettings::class, [
            [
                [
                    ['files'],
                    'file',
                    'maxFiles' => 5,
                    'mimeTypes' => Module::DEFAULT_ATTACHMENTS_MIME_TYPE,
                ],
            ],
            Module::DEFAULT_ATTACHMENTS_MIME_TYPE,
        ]);
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
        if (!$this->getDi()->has(FilesystemInterface::class)) {
            $path = Yii::getAlias($this->getModule()->attachmentPath);
            FileHelper::createDirectory($path);

            $this->setSingleton(AdapterInterface::class, Local::class, [$path]);
            $this->setSingleton(FilesystemInterface::class, Filesystem::class);
        }

        $this->checkDIClass(AdapterInterface::class);
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

        $this->set(AgentGridViewSettingsInterface::class, AgentGridViewSettings::class);
        $this->set(CustomerGridViewSettingsInterface::class, CustomerGridViewConfig::class);
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
}
