<?php

namespace SSupport\Module\Referee\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromCustomerInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

final class GetRecipientsFromCustomer implements GetRecipientsFromCustomerInterface
{
    /**
     * @param TicketInterface|RefereeTicketInterface $ticket
     */
    public function __invoke(TicketInterface $ticket): iterable
    {
        $result = [$ticket->getAssigns()[0]];

        if ($ticket->getReferee()) {
            $result[] = $ticket->getReferee();
        }

        return $result;
    }
}
