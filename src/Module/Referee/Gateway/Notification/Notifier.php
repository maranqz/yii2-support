<?php

namespace SSupport\Module\Referee\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Gateway\Notification\NotifierInterface;

class Notifier implements NotifierInterface
{
    public function sendMessageFromReferee(
        iterable $recipients,
        RefereeTicketInterface $ticket,
        MessageInterface $message
    ) {
        // TODO: Implement createMessageFromReferee() method.
    }

    public function customerRequestReferee(iterable $recipients, RefereeTicketInterface $ticket)
    {
        // TODO: Implement customerRequestReferee() method.
    }
}
