<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetDefaultAgentsForTicketInterface;

final class GetDefaultAgentsForTicket implements GetDefaultAgentsForTicketInterface
{
    public function __invoke(TicketInterface $ticket): iterable
    {
        return [];
    }
}
