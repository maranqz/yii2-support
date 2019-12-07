<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface RequestRefereeInputInterface
{
    public function getTicket(): RefereeTicketInterface;

    public function getReferee(): RefereeInterface;
}
