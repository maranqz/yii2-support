<?php

namespace SSupport\Module\Core\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Notification\NotifierInterface;

class Notifier implements NotifierInterface
{
    public function sendTicket(iterable $recipients, TicketInterface $ticket, MessageInterface $message)
    {
        // TODO: Implement createTicket() method.
    }

    public function sendMessageFromAgent(iterable $recipients, TicketInterface $ticket, MessageInterface $message)
    {
        // TODO: Implement createMessageFromAgent() method.
    }

    public function sendMessageFromCustomer(iterable $recipients, TicketInterface $ticket, MessageInterface $message)
    {
        // TODO: Implement createMessageFromCustomer() method.
    }
}
