<?php

namespace SSupport\Component\Referee\Gateway\Repository;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Repository\UserRepositoryInterface as BaseUserRepositoryInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface UserRepositoryInterface extends BaseUserRepositoryInterface
{
    /** @return UserInterface[] */
    public function getRecipientsForTicketFromReferee(RefereeTicketInterface $ticket): iterable;
}
