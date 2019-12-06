<?php

namespace Support\Component\Referee\Gateway\Repository;

use Support\Component\Core\Entity\UserInterface;
use Support\Component\Core\Gateway\Repository\UserRepositoryInterface as BaseUserRepositoryInterface;
use Support\Component\Referee\Entity\RefereeTicketInterface;

interface UserRepositoryInterface extends BaseUserRepositoryInterface
{
    /** @return UserInterface[] */
    public function getRecipientsForTicketFromReferee(RefereeTicketInterface $ticket): iterable;
}
