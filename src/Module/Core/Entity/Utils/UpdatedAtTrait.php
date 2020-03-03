<?php

namespace SSupport\Module\Core\Entity\Utils;

use DateTimeImmutable;
use DateTimeInterface;
use SSupport\Component\Core\Entity\Utils\UpdatedAtInterface;

trait UpdatedAtTrait
{
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat('U', $this->__get('updated_at') ?? time());
    }

    public function setUpdatedAt(DateTimeInterface $dateTime): UpdatedAtInterface
    {
        $this->__set('updated_at', $dateTime->getTimestamp());

        return $this;
    }
}
