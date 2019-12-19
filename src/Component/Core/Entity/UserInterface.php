<?php

namespace SSupport\Component\Core\Entity;

use SSupport\Component\Core\Entity\Utils\IdentifyInterface;

interface UserInterface extends IdentifyInterface
{
    public function getNickname(): string;
}
