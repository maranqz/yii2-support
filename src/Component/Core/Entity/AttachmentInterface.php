<?php

namespace Support\Component\Core\Entity;

use Support\Component\Core\Entity\Utils\IdentifyInterface;

interface AttachmentInterface extends IdentifyInterface
{
    public function getName(): string;

    /** @return int */
    public function getSize();
}
