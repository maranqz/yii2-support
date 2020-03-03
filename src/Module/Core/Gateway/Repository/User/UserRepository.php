<?php

namespace SSupport\Module\Core\Gateway\Repository\User;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetDefaultAgentsForTicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsForNewTicketInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromAgentInterface;
use SSupport\Component\Core\Gateway\Repository\User\GetRecipientsFromCustomerInterface;
use SSupport\Component\Core\Gateway\Repository\User\UserRepositoryInterface;
use yii\db\ActiveQuery;

final class UserRepository extends ActiveQuery implements UserRepositoryInterface
{
    private $getDefaultAgentsForTicket;
    private $getRecipientsForNewTicket;
    private $getRecipientsFromCustomer;
    private $getRecipientsFromAgent;

    public function __construct(
        $modelClass,
        GetDefaultAgentsForTicketInterface $getDefaultAgentsForTicket,
        GetRecipientsForNewTicketInterface $getRecipientsForNewTicket,
        GetRecipientsFromCustomerInterface $getRecipientsFromCustomer,
        GetRecipientsFromAgentInterface $getRecipientsFromAgent,
        $config = []
    ) {
        parent::__construct($modelClass, $config);

        $this->getDefaultAgentsForTicket = $getDefaultAgentsForTicket;
        $this->getRecipientsForNewTicket = $getRecipientsForNewTicket;
        $this->getRecipientsFromCustomer = $getRecipientsFromCustomer;
        $this->getRecipientsFromAgent = $getRecipientsFromAgent;
    }

    public function getDefaultAgentsForTicket(TicketInterface $ticket): iterable
    {
        return ($this->getDefaultAgentsForTicket)($ticket);
    }

    public function getRecipientsForNewTicket(TicketInterface $ticket): iterable
    {
        return ($this->getRecipientsForNewTicket)($ticket);
    }

    public function getRecipientsFromAgent(TicketInterface $ticket): iterable
    {
        return ($this->getRecipientsFromAgent)($ticket);
    }

    public function getRecipientsFromCustomer(TicketInterface $ticket): iterable
    {
        return ($this->getRecipientsFromCustomer)($ticket);
    }
}
