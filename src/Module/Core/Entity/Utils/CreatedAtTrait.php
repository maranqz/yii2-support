<?php

namespace SSupport\Module\Core\Entity\Utils;

use DateTimeInterface;
use DateTimeImmutable;

trait CreatedAtTrait
{
    public function getCreatedAt(): ?DateTimeInterface
    {
        return DateTimeImmutable::createFromFormat('U', $this->__get('created_at'));
    }
}
