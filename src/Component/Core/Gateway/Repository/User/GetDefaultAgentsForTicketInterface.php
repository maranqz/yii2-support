<?php

namespace SSupport\Component\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface GetDefaultAgentsForTicketInterface
{
    /** @return UserInterface[] */
    public function __invoke(TicketInterface $ticket): iterable;
}
