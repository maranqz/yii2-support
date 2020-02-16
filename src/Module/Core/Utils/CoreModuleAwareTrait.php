<?php

namespace SSupport\Module\Core\Utils;

use SSupport\Module\Core\Module;
use Yii;

trait CoreModuleAwareTrait
{
    /**
     * @return Module
     */
    public function getSupportCoreModule()
    {
        return Yii::$app->getModule(Module::$name);
    }
}
