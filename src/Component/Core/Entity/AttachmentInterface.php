<?php

namespace SSupport\Component\Core\Entity;

use SSupport\Component\Core\Entity\Utils\IdentifyInterface;

interface AttachmentInterface extends IdentifyInterface
{
    public function getPath(): string;

    public function getName(): string;

    /** @return int */
    public function getSize();
}
