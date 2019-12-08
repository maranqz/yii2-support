<?php

namespace SSupport\Module\Core;

use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Entity\Attachment;
use SSupport\Module\Core\Entity\Message;
use SSupport\Module\Core\Entity\Ticket;
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

    public function bootstrap($app)
    {
        $this->initContainer($app, $app->getModule(Module::$name)->classMap);
        $this->initTranslations($app);

        if ($app instanceof WebApplication) {
            $this->initWebApplication($app);
        }
    }

    protected function initContainer(Application $app, $map)
    {
        try {
            $this->initMap($map);
            $this->initDefaultFilesystem();
            $this->initEntity();
        } catch (Exception $e) {
            die($e);
        }
    }

    protected function initEntity()
    {
        $di = $this->getDi();

        $di->set(TicketInterface::class, Ticket::class);
        $di->set(MessageInterface::class, Message::class);
        $di->set(AttachmentInterface::class, Attachment::class);
    }

    protected function initMap($map)
    {
        $di = $this->getDi();

        $this->checkInitMapClass($map, UserInterface::class);
        foreach ($map as $class => $definition) {
            $di->set($class, $definition);
        }
    }

    protected function checkInitMapClass($map, $interface)
    {
        if (empty($map[$interface])) {
            throw new \InvalidArgumentException('Map for "'.$interface.'" should be set.');
        }
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
