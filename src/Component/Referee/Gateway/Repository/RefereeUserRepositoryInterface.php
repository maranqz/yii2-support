<?php

namespace SSupport\Component\Referee\Gateway\Repository;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface RefereeUserRepositoryInterface
{
    /** @return UserInterface[] */
    public function getRecipientsForTicketFromReferee(RefereeTicketInterface $ticket): iterable;

    public function getRefereeForTicket(RefereeTicketInterface $ticket): RefereeInterface;
}
