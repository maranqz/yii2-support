<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class BeforeSetTimeoutRequest extends StoppableEvent implements BeforeSetTimeoutRequestInterface
{
    protected $inputDTO;

    public function __construct(SetTimeoutRequestInputInterface $inputDTO)
    {
        $this->inputDTO = $inputDTO;
    }

    public function getInput(): SetTimeoutRequestInputInterface
    {
        return $this->inputDTO;
    }
}
