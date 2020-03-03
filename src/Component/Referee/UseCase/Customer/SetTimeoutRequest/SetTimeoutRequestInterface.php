<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

interface SetTimeoutRequestInterface
{
    public function __invoke(SetTimeoutRequestInputInterface $inputDTO);
}
