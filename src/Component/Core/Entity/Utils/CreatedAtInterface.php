<?php

namespace SSupport\Component\Core\Entity\Utils;

use DateTimeInterface;

interface CreatedAtInterface
{
    public function getCreatedAt(): ?DateTimeInterface;
}
