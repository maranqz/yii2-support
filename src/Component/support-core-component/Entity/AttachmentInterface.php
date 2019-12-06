<?php

namespace Support\Component\Core\Entity;

use Support\Component\Core\Entity\Utils\IdentifyInterface;

interface AttachmentInterface extends IdentifyInterface
{
    public function getName(): string;

    public function getSize(): float;
}
