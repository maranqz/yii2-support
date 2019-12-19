<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetTicketDefaultAgentsInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;
use yii\db\ActiveQuery;

final class UserRepository extends ActiveQuery implements UserRepositoryInterface
{
    private $getTicketDefaultAgents;

    public function __construct($modelClass, GetTicketDefaultAgentsInterface $getTicketDefaultAgents, $config = [])
    {
        parent::__construct($modelClass, $config);

        $this->getTicketDefaultAgents = $getTicketDefaultAgents;
    }

    public function getAssignAgentsNewTicket(TicketInterface $ticket): iterable
    {
        return ($this->getTicketDefaultAgents)($ticket);
    }

    public function getNoticeAgentsNewTicket(TicketInterface $ticket): iterable
    {
        return $ticket->getAssigns()[0];
    }

    public function getRecipientsForTicketFromCustomer(TicketInterface $ticket): iterable
    {
        return [$ticket->getAssigns()[0]];
    }

    public function getRecipientsForTicketFromAgent(TicketInterface $ticket): iterable
    {
        // TODO: Implement getRecipientsForTicketFromAgent() method.
        return [];
    }
}
