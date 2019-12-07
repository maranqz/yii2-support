<?php

namespace SSupport\Module\Core;

use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\helpers\FileHelper;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->initContainer($app, []);
    }

    protected function initContainer(Application $app, $map)
    {
        $di = Yii::$container;
        try {
            $this->initDefaultFilesystem($di);
        } catch (Exception $e) {
            die($e);
        }
    }

    protected function initDefaultFilesystem(Container $di)
    {
        if (!$di->has(FilesystemInterface::class)) {
            $di->set(FilesystemInterface::class, function () {
                $path = Yii::getAlias('@webroot/support/attachment');
                FileHelper::createDirectory($path);

                $adapter = new Local($path);

                return new Filesystem($adapter);
            });
        }
    }
}
