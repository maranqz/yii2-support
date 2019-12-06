<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

interface BeforeCreateTicketInterface
{
    public function getInput(): CreateTicketInputInterface;
}
