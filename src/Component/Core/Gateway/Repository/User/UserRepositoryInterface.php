<?php

namespace SSupport\Component\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Repository\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /** @return UserInterface[] */
    public function getAssignAgentsNewTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getNoticeAgentsNewTicket(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromCustomer(TicketInterface $ticket): iterable;

    /** @return UserInterface[] */
    public function getRecipientsForTicketFromAgent(TicketInterface $ticket): iterable;
}
