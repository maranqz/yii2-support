<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetTicketDefaultAgentsInterface;

class EmptyGetTicketDefaultAgents implements GetTicketDefaultAgentsInterface
{
    public function __invoke(TicketInterface $ticket): iterable
    {
        return [];
    }
}
