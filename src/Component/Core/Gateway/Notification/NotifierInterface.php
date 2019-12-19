<?php

namespace SSupport\Component\Core\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;

interface NotifierInterface
{
    public function sendTicket(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function sendMessageFromAgent(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function sendMessageFromCustomer(iterable $recipients, TicketInterface $ticket, MessageInterface $message);
}
