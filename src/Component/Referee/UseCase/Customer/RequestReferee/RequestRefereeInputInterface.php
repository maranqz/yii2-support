<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface RequestRefereeInputInterface
{
    public function getTicket(): RefereeTicketInterface;

    /**
     * @return UserInterface|null
     */
    public function getRequester();
}
