<?php

namespace SSupport\Component\Core\Entity\Utils;

use DateTimeInterface;

interface UpdatedAtInterface
{
    public function getUpdatedAt(): ?DateTimeInterface;

    public function setUpdatedAt(DateTimeInterface $dateTime): UpdatedAtInterface;
}
