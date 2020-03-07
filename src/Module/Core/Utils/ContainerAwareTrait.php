<?php

namespace SSupport\Module\Core\Utils;

use Yii;
use yii\base\InvalidConfigException;

trait ContainerAwareTrait
{
    public static function getDi()
    {
        return Yii::$container;
    }

    public static function make($class, $params = [], $config = [])
    {
        return static::getDi()->get($class, $params, $config);
    }

    public static function getDIClass($class)
    {
        static::checkDIClass($class);

        return static::getDIClassOrNull($class);
    }

    protected static function getDIClassOrNull($class)
    {
        if (static::hasDICass($class)) {
            $definitions = static::getDIDefinitionOrNull($class);

            return static::getDIClassOrNull($definitions['class']);
        }

        return $class;
    }

    public static function getDIDefinition($class)
    {
        static::checkDIClass($class);

        return static::getDIDefinitionOrNull($class);
    }

    public static function getDIDefinitionOrNull($class)
    {
        return static::getDi()->getDefinitions()[$class];
    }

    public static function checkDIClass($class)
    {
        if (!(static::hasDICass($class) || class_exists($class))) {
            throw new InvalidConfigException('Failed to instantiate component or class "' . $class . '".');
        }
    }

    protected static function hasDICass($class)
    {
        return static::getDi()->has($class);
    }

    protected static function set($class, $definition = [], array $params = [], $replace = false)
    {
        $di = static::getDi();
        if (!$replace && $di->has($class)) {
            return;
        }

        $di->set($class, $definition, $params);
    }

    protected static function setSingleton($class, $definition = [], array $params = [], $replace = false)
    {
        $di = static::getDi();
        if (!$replace && $di->has($class)) {
            return;
        }

        $di->setSingleton($class, $definition, $params);
    }
}
