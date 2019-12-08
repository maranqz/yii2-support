<?php

namespace SSupport\Module\Core;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    const DEFAULT_NAME = 'support';

    public static $name = self::DEFAULT_NAME;

    public $prefix = self::DEFAULT_NAME;

    public $routes = [
        '' => 'ticket/index',
    ];

    public $defaultRoute = 'ticket/index';

    public $controllerNamespace = 'SSupport\Module\Core\Controller';

    public $classMap = [];
}
