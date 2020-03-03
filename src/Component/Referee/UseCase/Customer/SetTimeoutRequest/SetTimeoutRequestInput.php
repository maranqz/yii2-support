<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;

class SetTimeoutRequestInput implements SetTimeoutRequestInputInterface
{
    protected $timeoutRequest;
    protected $timeout;
    protected $requester;

    public function __construct(
        TimeoutRequestRefereeInterface $timeoutRequest,
        $timeout,
        UserInterface $requester = null
    ) {
        $this->timeoutRequest = $timeoutRequest;
        $this->timeout = $timeout;
        $this->requester = $requester;
    }

    public function getTimeoutRequest(): TimeoutRequestRefereeInterface
    {
        return $this->timeoutRequest;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getRequester(): UserInterface
    {
        return $this->requester;
    }
}
