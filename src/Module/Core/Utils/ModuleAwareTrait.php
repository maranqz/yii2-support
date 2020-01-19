<?php

namespace SSupport\Module\Core\Utils;

use SSupport\Module\Core\Module;
use Yii;

trait ModuleAwareTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return Yii::$app->getModule(Module::$name);
    }
}
