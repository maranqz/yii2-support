<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\InputAwareInterface;

interface AfterCreateTicketInterface extends InputAwareInterface
{
    public function getInput(): CreateTicketInputInterface;

    public function getTicket(): TicketInterface;
}
