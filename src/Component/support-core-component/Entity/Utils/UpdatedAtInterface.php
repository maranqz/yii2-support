<?php

namespace Support\Component\Core\Entity\Utils;

interface UpdatedAtInterface
{
    public function getUpdatedAt(): ?\DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $dateTime): self;
}
