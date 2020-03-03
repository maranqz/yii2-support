<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\UseCase\InputAwareInterface;

interface AfterSetTimeoutRequestInterface extends InputAwareInterface
{
    public function getInput(): SetTimeoutRequestInputInterface;
}
