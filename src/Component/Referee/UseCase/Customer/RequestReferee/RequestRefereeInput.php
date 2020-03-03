<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

class RequestRefereeInput implements RequestRefereeInputInterface
{
    protected $ticket;
    protected $requester;

    public function __construct(
        RefereeTicketInterface $ticket,
        UserInterface $requester = null
    ) {
        $this->ticket = $ticket;
        $this->requester = $requester;
    }

    public function getTicket(): RefereeTicketInterface
    {
        return $this->ticket;
    }

    public function getRequester()
    {
        return $this->requester;
    }
}
