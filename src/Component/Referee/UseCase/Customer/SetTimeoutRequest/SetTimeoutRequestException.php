<?php

namespace SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest;

use Throwable;

class SetTimeoutRequestException extends \RuntimeException
{
    public function __construct(
        $message = 'Timeout have already been set.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
