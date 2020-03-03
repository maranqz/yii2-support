<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;

interface SetTimeoutRequestInputInterface
{
    public function getTimeoutRequest(): TimeoutRequestRefereeInterface;

    public function getTimeout();

    public function getRequester(): UserInterface;
}
