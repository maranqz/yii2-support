<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

interface BeforeCreateTicketInterface
{
    public function getInput(): CreateTicketInputInterface;
}
