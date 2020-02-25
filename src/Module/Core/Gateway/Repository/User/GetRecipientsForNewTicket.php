<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsForNewTicketInterface;

final class GetRecipientsForNewTicket implements GetRecipientsForNewTicketInterface
{
    public function __invoke(TicketInterface $ticket): iterable
    {
        return [$ticket->getAssigns()[0]];
    }
}
