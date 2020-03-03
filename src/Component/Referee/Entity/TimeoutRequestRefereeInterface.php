<?php

namespace SSupport\Component\Referee\Entity;

use SSupport\Component\Core\Entity\UserInterface;

interface TimeoutRequestRefereeInterface
{
    public function setTimeoutRequest($timeout, UserInterface $requester = null);

    public function getTimeoutRequest();

    public function getRemainingTimeoutRequest();

    public function alreadyTimeoutRequest(): bool;

    public function isTimeoutRequestUp(): bool;

    public function getTicket(): RefereeTicketInterface;
}
