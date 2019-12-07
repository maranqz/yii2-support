<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Event;

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
