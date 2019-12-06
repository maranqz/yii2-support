<?php

namespace Support\Component\Referee\UseCase\Customer\RequestReferee;

use Support\Component\Referee\Entity\RefereeInterface;
use Support\Component\Referee\Entity\RefereeTicketInterface;

interface RequestRefereeInputInterface
{
    public function getTicket(): RefereeTicketInterface;

    public function getReferee(): RefereeInterface;
}
