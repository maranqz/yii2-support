<?php

namespace SSupport\Component\Core\Gateway\Notification;

use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessageInterface as AgentAfterSendMessageInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\AfterCreateTicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessageInterface as CustomerAfterSendMessageInterface;

interface NotifierListenerInterface
{
    public function newTicket(AfterCreateTicketInterface $event);

    public function sendMessageFromAgent(AgentAfterSendMessageInterface $event);

    public function sendMessageFromCustomer(CustomerAfterSendMessageInterface $event);
}
