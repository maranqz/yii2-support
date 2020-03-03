<?php

namespace SSupport\Module\Core\Controller;

trait BlockTrait
{
    public $blocks;

    public function inPlace($blockName)
    {
        return empty($this->blocks[$blockName]);
    }
}
