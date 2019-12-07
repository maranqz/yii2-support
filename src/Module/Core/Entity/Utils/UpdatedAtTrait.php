<?php

namespace SSupport\Module\Core\Entity\Utils;

use SSupport\Component\Core\Entity\Utils\UpdatedAtInterface;
use DateTimeImmutable;
use DateTimeInterface;

trait UpdatedAtTrait
{
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat('U', $this->__get('updated_at'));
    }

    public function setUpdatedAt(DateTimeInterface $dateTime): UpdatedAtInterface
    {
        $this->__set('updated_at', $dateTime->getTimestamp());

        return $this;
    }
}
