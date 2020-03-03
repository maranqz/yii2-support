<?php

namespace SSupport\Component\Referee\Gateway\Repository\User;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface UserRepositoryInterface
{
    /** @return UserInterface[] */
    public function getRecipientsFromReferee(RefereeTicketInterface $ticket): iterable;

    public function getRefereeForTicket(RefereeTicketInterface $ticket): RefereeInterface;
}
