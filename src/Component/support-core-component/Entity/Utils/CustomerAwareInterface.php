<?php

namespace Support\Component\Core\Entity\Utils;

use Support\Component\Core\Entity\UserInterface;

interface CustomerAwareInterface
{
    public function getCustomer(): ?UserInterface;

    public function setCustomer(?UserInterface $customer): self;
}
