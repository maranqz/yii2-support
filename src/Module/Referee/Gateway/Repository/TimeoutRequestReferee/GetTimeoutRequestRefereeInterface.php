<?php

namespace SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;

interface GetTimeoutRequestRefereeInterface
{
    public function __invoke(TicketInterface $ticket): TimeoutRequestRefereeInterface;
}
