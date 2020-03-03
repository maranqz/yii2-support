<?php

namespace SSupport\Module\Referee\Utils;

use SSupport\Module\Referee\Module;
use Yii;

trait RefereeModuleAwareTrait
{
    /**
     * @return Module
     */
    public function getSupportRefereeModule()
    {
        return Yii::$app->getModule(Module::$name);
    }
}
