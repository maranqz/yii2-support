<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

interface BeforeRequestRefereeInterface
{
    public function getInput(): RequestRefereeInputInterface;
}
