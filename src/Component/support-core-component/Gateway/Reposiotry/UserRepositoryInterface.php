<?php

namespace Support\Component\Core\Gateway\Repository;

use Support\Component\Core\Entity\TicketInterface;
use Support\Component\Core\Entity\UserInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /** @return UserInterface[] */
    public function getAgentsForUnsignedTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromCustomer(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromAgent(TicketInterface $ticket): iterable;
}
