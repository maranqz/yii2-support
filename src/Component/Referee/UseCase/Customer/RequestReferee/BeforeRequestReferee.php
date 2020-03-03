<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class BeforeRequestReferee extends StoppableEvent implements BeforeRequestRefereeInterface
{
    protected $inputDTO;

    public function __construct(RequestRefereeInputInterface $inputDTO)
    {
        $this->inputDTO = $inputDTO;
    }

    public function getInput(): RequestRefereeInputInterface
    {
        return $this->inputDTO;
    }
}
