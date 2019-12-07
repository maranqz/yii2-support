<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\TicketInterface;

interface AfterCreateTicketInterface
{
    public function getTicket(): TicketInterface;
}
