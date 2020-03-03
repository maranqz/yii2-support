<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\UseCase\InputAwareInterface;

interface BeforeSetTimeoutRequestInterface extends InputAwareInterface
{
    public function getInput(): SetTimeoutRequestInputInterface;
}
