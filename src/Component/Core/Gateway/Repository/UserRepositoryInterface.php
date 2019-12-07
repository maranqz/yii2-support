<?php

namespace SSupport\Component\Core\Gateway\Repository;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /** @return UserInterface[] */
    public function getAgentsForUnsignedTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromCustomer(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromAgent(TicketInterface $ticket): iterable;
}
