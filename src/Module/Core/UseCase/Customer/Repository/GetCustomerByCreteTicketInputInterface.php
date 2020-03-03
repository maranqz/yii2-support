<?php

namespace SSupport\Module\Core\UseCase\Customer\Repository;

use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;

interface GetCustomerByCreteTicketInputInterface
{
    public function __invoke(CreateTicketInputInterface $input): CustomerInterface;
}
