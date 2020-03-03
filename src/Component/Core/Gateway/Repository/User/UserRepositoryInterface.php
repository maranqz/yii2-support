<?php

namespace SSupport\Component\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Repository\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /** @return UserInterface[] */
    public function getDefaultAgentsForTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForNewTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsFromCustomer(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsFromAgent(TicketInterface $ticket): iterable;
}
