<?php

namespace SSupport\Component\Referee\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface NotifierInterface
{
    public function sendMessageFromReferee(
        iterable $recipients,
        RefereeTicketInterface $ticket,
        MessageInterface $message
    );

    public function customerRequestReferee(iterable $recipients, RefereeTicketInterface $ticket);
}
