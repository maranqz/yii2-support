<?php

namespace SSupport\Module\Core\Factory;

use SSupport\Component\Core\Factory\FactoryInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

final class Factory implements FactoryInterface
{
    use ContainerAwareTrait;

    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public function createNew()
    {
        return $this->make($this->className);
    }
}
