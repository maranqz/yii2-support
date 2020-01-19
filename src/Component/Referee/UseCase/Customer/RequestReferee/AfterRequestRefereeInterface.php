<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use SSupport\Component\Core\UseCase\InputAwareInterface;

interface AfterRequestRefereeInterface extends InputAwareInterface
{
    public function getInput(): RequestRefereeInputInterface;
}
