<?php

namespace SSupport\Component\Core\Entity\Utils;

use SSupport\Component\Core\Entity\UserInterface;

interface CustomerAwareInterface
{
    public function getCustomer(): UserInterface;

    public function setCustomer(UserInterface $customer): self;
}
