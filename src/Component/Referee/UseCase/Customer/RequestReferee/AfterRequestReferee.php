<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class AfterRequestReferee extends StoppableEvent implements AfterRequestRefereeInterface
{
    protected $input;

    public function __construct(RequestRefereeInputInterface $input)
    {
        $this->input = $input;
    }

    public function getInput(): RequestRefereeInputInterface
    {
        return $this->input;
    }
}
