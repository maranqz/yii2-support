<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

interface RequestRefereeInterface
{
    public function __invoke(RequestRefereeInputInterface $inputDTO);
}
