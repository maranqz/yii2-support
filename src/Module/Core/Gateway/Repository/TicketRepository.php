<?php

namespace SSupport\Module\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;
use SSupport\Module\Core\Utils\RepositoryTrait;

class TicketRepository implements TicketRepositoryInterface
{
    use RepositoryTrait;

    public function add(TicketInterface $ticket): TicketRepositoryInterface
    {
        return $this->trySave($ticket);
    }

    public function save(TicketInterface $ticket): TicketRepositoryInterface
    {
        return $this->trySave($ticket);
    }

    public function remove(TicketInterface $ticket): TicketRepositoryInterface
    {
        return $this->tryDelete($ticket);
    }
}
