<?php

namespace SSupport\Component\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;

interface TicketRepositoryInterface extends RepositoryInterface
{
    public function save(TicketInterface $ticket);
}
