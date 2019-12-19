<?php

namespace SSupport\Component\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;

interface TicketRepositoryInterface extends RepositoryInterface
{
    public function add(TicketInterface $ticket): self;

    public function save(TicketInterface $ticket): self;

    public function remove(TicketInterface $ticket): self;
}
