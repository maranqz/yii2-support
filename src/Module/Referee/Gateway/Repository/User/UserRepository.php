<?php

namespace SSupport\Module\Referee\Gateway\Repository\User;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Repository\User\AbstractUserRepository;
use SSupport\Component\Referee\Gateway\Repository\User\UserRepositoryInterface;

class UserRepository extends AbstractUserRepository implements UserRepositoryInterface
{
    public function getRecipientsFromReferee(RefereeTicketInterface $ticket): iterable
    {
        $recipients = $ticket->getAssigns();
        $recipients[] = $ticket->getCustomer();

        return $recipients;
    }
}
