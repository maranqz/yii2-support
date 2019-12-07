<?php

namespace SSupport\Component\Core\Gateway\Notification;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;

interface NotifierInterface
{
    public function createTicket(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function createMessageFromAgent(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function createMessageFromCustomer(iterable $recipients, TicketInterface $ticket, MessageInterface $message);
}
