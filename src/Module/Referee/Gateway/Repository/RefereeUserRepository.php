<?php

namespace SSupport\Module\Referee\Gateway\Repository;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Repository\AbstractRefereeUserRepository;
use SSupport\Component\Referee\Gateway\Repository\RefereeUserRepositoryInterface;

class RefereeUserRepository extends AbstractRefereeUserRepository implements RefereeUserRepositoryInterface
{
    public function getRecipientsForTicketFromReferee(RefereeTicketInterface $ticket): iterable
    {
        $recipients = $ticket->getAssigns();
        $recipients[] = $ticket->getCustomer();

        return $recipients;
    }
}
