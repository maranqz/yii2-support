<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

use Support\Component\Core\Entity\TicketInterface;

interface AfterCreateTicketInterface
{
    public function getTicket(): TicketInterface;
}
