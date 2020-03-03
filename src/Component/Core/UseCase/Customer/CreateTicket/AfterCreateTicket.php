<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class AfterCreateTicket extends StoppableEvent implements AfterCreateTicketInterface
{
    protected $input;
    protected $ticket;

    public function __construct(CreateTicketInputInterface $input, TicketInterface $ticket)
    {
        $this->input = $input;
        $this->ticket = $ticket;
    }

    public function getInput(): CreateTicketInputInterface
    {
        return $this->input;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }
}
