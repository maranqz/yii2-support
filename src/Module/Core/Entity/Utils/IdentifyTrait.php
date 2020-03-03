<?php

namespace SSupport\Module\Core\Entity\Utils;

trait IdentifyTrait
{
    /** @psalm-suppress MissingReturnType */
    public function getId()
    {
        return $this->__get('id');
    }
}
