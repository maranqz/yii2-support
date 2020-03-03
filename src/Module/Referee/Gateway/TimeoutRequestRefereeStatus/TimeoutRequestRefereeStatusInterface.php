<?php

namespace SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface TimeoutRequestRefereeStatusInterface
{
    public function canRequestReferee(RefereeTicketInterface $ticket): bool;

    public function canSetTimeoutRequestReferee(RefereeTicketInterface $ticket): bool;

    public function hasReferee(RefereeTicketInterface $ticket): bool;
}
