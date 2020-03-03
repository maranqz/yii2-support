<?php

namespace SSupport\Module\Referee\Gateway\Repository\TimeoutRequestReferee;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;
use yii\base\NotSupportedException;

final class TicketGetTimeoutRequestReferee implements GetTimeoutRequestRefereeInterface
{
    public function __invoke(TicketInterface $ticket): TimeoutRequestRefereeInterface
    {
        if (!$ticket instanceof TimeoutRequestRefereeInterface) {
            throw new NotSupportedException();
        }

        return $ticket;
    }
}
