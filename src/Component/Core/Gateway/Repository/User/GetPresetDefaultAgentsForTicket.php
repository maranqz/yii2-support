<?php

namespace SSupport\Component\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

class GetPresetDefaultAgentsForTicket implements GetDefaultAgentsForTicketInterface
{
    private $agents;

    public function __construct(UserInterface $agent)
    {
        $this->agents = [$agent];
    }

    public function __invoke(TicketInterface $ticket): iterable
    {
        return $this->agents;
    }
}
