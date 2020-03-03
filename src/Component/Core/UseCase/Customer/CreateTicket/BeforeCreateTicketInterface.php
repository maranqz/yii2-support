<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\UseCase\InputAwareInterface;

interface BeforeCreateTicketInterface extends InputAwareInterface
{
    public function getInput(): CreateTicketInputInterface;
}
