<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromAgentInterface;

final class GetRecipientsFromAgent implements GetRecipientsFromAgentInterface
{
    public function __invoke(TicketInterface $ticket): iterable
    {
        return [$ticket->getAssigns()[0]];
    }
}
