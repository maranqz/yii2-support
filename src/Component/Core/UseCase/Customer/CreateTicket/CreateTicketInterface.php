<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

use Support\Component\Core\Entity\TicketInterface;

interface CreateTicketInterface
{
    public function __invoke(CreateTicketInputInterface $ticketInput): TicketInterface;
}
