<?php

namespace SSupport\Component\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;

class GetEmptyDefaultAgentsForTicket implements GetDefaultAgentsForTicketInterface
{
    public function __invoke(TicketInterface $ticket): iterable
    {
        return [];
    }
}
