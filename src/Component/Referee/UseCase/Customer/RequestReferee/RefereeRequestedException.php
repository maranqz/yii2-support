<?php

namespace SSupport\Component\Referee\UseCase\Customer\RequestReferee;

use Throwable;

class RefereeRequestedException extends \RuntimeException
{
    public function __construct(
        $message = 'Referee have already been requested for ticket.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
