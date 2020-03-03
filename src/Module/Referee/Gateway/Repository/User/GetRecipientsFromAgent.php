<?php

namespace SSupport\Module\Referee\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromAgentInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

final class GetRecipientsFromAgent implements GetRecipientsFromAgentInterface
{
    /**
     * @param TicketInterface|RefereeTicketInterface $ticket
     */
    public function __invoke(TicketInterface $ticket): iterable
    {
        $result = [$ticket->getCustomer()];

        if ($ticket->getReferee()) {
            $result[] = $ticket->getReferee();
        }

        return $result;
    }
}
