<?php

namespace Support\Component\Referee\UseCase\Customer\RequestReferee;

use Support\Component\Core\Gateway\Event;

class BeforeRequestReferee extends Event implements BeforeRequestRefereeInterface
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
