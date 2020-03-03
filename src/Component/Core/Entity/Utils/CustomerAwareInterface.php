<?php

namespace SSupport\Component\Core\Entity\Utils;

use SSupport\Component\Core\Entity\CustomerInterface;

interface CustomerAwareInterface
{
    public function getCustomer(): CustomerInterface;

    public function setCustomer(CustomerInterface $customer): self;
}
