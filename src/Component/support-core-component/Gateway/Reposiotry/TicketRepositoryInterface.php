<?php

namespace Support\Component\Core\Gateway\Repository;

use Support\Component\Core\Entity\TicketInterface;

interface TicketRepositoryInterface extends RepositoryInterface
{
    public function save(TicketInterface $ticket);
}
