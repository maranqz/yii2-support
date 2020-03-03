<?php

namespace SSupport\Module\Referee\Resource\config\GridView;

use SSupport\Module\Core\Resource\config\GridView\CommonGridViewSettingsInterface;

interface RefereeGridViewSettingsInterface extends CommonGridViewSettingsInterface
{
    public function assign();

    public function customer();
}
