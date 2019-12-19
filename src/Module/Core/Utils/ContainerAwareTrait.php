<?php

namespace SSupport\Module\Core\Utils;

use Yii;
use yii\base\InvalidConfigException;

trait ContainerAwareTrait
{
    public function getDi()
    {
        return Yii::$container;
    }

    public function make($class, $params = [], $config = [])
    {
        return $this->getDi()->get($class, $params, $config);
    }

    public function getDIClass($class)
    {
        return $this->getDIDefinition($class)['class'];
    }

    public function getDIDefinition($class)
    {
        $this->checkDIClass($class);

        return $this->getDi()->getDefinitions()[$class];
    }

    public function checkDIClass($class)
    {
        if (!$this->getDi()->has($class)) {
            throw new InvalidConfigException('Failed to instantiate component or class "'.$class.'".');
        }
    }
}
