<?php

namespace SSupport\Component\Referee\Gateway\Notification;

use SSupport\Component\Core\UseCase\Agent\SendMessage\AfterSendMessageInterface as AgentAfterSendMessageInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\AfterSendMessageInterface as CustomerAfterSendMessageInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\AfterRequestReferee;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\AfterSendMessageInterface;

interface NotifierListenerInterface
{
    public function sendMessageFromReferee(AfterSendMessageInterface $event);

    public function sendMessageFromAgent(AgentAfterSendMessageInterface $event);

    public function sendMessageFromCustomer(CustomerAfterSendMessageInterface $event);

    public function customerRequestRefereeForReferee(AfterRequestReferee $event);
}
