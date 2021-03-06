<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class BeforeCreateTicket extends StoppableEvent implements BeforeCreateTicketInterface
{
    protected $ticketInput;

    public function __construct(CreateTicketInputInterface $ticketInput)
    {
        $this->ticketInput = $ticketInput;
    }

    public function getInput(): CreateTicketInputInterface
    {
        return $this->ticketInput;
    }
}
