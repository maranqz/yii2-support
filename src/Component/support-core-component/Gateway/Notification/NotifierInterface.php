<?php

namespace Support\Component\Core\Gateway\Notification;

use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Core\Entity\TicketInterface;

interface NotifierInterface
{
    public function createTicket(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function createMessageFromAgent(iterable $recipients, TicketInterface $ticket, MessageInterface $message);

    public function createMessageFromCustomer(iterable $recipients, TicketInterface $ticket, MessageInterface $message);
}
