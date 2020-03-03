<?php

namespace SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee\GetTimeoutRequestRefereeInterface;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;

class TimeoutRequestRefereeStatus implements TimeoutRequestRefereeStatusInterface
{
    use RefereeModuleAwareTrait;

    public $getTimeoutRequestReferee;
    public $timeoutRequestReferee;

    public function __construct(GetTimeoutRequestRefereeInterface $getTimeoutRequestReferee)
    {
        $this->getTimeoutRequestReferee = $getTimeoutRequestReferee;
        $this->timeoutRequestReferee = $this->getSupportRefereeModule()->timeoutRequestReferee;
    }

    public function canRequestReferee(RefereeTicketInterface $ticket): bool
    {
        return !$ticket->hasReferee() && (
                !$this->timeoutRequestReferee
                || ($this->getTimeoutRequestReferee)($ticket)->isTimeoutRequestUp()
            );
    }

    public function canSetTimeoutRequestReferee(RefereeTicketInterface $ticket): bool
    {
        return $this->timeoutRequestReferee
            && !($this->getTimeoutRequestReferee)($ticket)->alreadyTimeoutRequest();
    }

    public function hasReferee(RefereeTicketInterface $ticket): bool
    {
        return $ticket->hasReferee();
    }
}
