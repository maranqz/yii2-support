<?php

namespace SSupport\Module\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;

trait GetTicketByIdTrait
{
    protected $tickets = [];

    protected function getTicketById($ticketId)
    {
        if (empty($ticketId)) {
            return null;
        }

        if (empty($this->tickets[$ticketId])) {
            $this->tickets[$ticketId] = $this->make(TicketInterface::class)::findOne($ticketId);
        }

        return $this->tickets[$ticketId];
    }
}
