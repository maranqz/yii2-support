<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

use Support\Component\Core\Entity\TicketInterface;
use Support\Component\Core\Gateway\Event;

class AfterCreateTicket extends Event implements AfterCreateTicketInterface
{
    protected $ticket;

    public function __construct(TicketInterface $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }
}
