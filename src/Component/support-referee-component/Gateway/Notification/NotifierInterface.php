<?php

namespace Support\Component\Referee\Gateway\Notification;

use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Referee\Entity\RefereeTicketInterface;

interface NotifierInterface
{
    public function createMessageFromReferee(
        iterable $recipients,
        RefereeTicketInterface $ticket,
        MessageInterface $message
    );

    public function customerRequestReferee(iterable $recipients, RefereeTicketInterface $ticket);
}
