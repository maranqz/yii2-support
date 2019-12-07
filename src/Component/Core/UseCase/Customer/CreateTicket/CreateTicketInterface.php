<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\TicketInterface;

interface CreateTicketInterface
{
    public function __invoke(CreateTicketInputInterface $ticketInput): TicketInterface;
}
