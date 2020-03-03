<?php

namespace SSupport\Module\Core\UseCase\Form;

use SSupport\Component\Core\Entity\TicketInterface;

trait TicketAwareTrait
{
    protected $ticket;

    public function setTicket(TicketInterface $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }
}
