<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class AfterSetTimeoutRequest extends StoppableEvent implements AfterSetTimeoutRequestInterface
{
    protected $input;

    public function __construct(SetTimeoutRequestInputInterface $input)
    {
        $this->input = $input;
    }

    public function getInput(): SetTimeoutRequestInputInterface
    {
        return $this->input;
    }
}
