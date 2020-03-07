<?php

namespace SSupport;

use SSupport\Module\Core\Bootstrap as CoreSupportBootstrap;
use SSupport\Module\Core\Module as CoreSupportModule;
use SSupport\Module\Referee\Bootstrap as RefereeSupportBootstrap;
use SSupport\Module\Referee\Module as RefereeSupportModule;
use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    private $boostraps;

    public function __construct($boostraps = [])
    {
        if (empty($boostraps)) {
            $this->boostraps = [
                CoreSupportModule::$name => CoreSupportBootstrap::class,
                RefereeSupportModule::$name => RefereeSupportBootstrap::class,
            ];
        }
    }

    public function bootstrap($app)
    {
        foreach ($this->boostraps as $module => $boostrap) {
            if (!$app->hasModule($module)) {
                continue;
            }

            $component = Yii::createObject($boostrap);
            if ($component instanceof BootstrapInterface) {
                Yii::debug('Bootstrap with ' . \get_class($component) . '::bootstrap()', __METHOD__);
                $component->bootstrap($app);
            } else {
                Yii::debug('Bootstrap with ' . \get_class($component), __METHOD__);
            }
        }
    }
}
