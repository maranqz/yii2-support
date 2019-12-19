<?php

namespace SSupport\Module\Core\UseCase\Customer;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\UseCase\Form\AbstractSendMessageInputForm as BaseSendMessageForm;
use SSupport\Module\Core\UseCase\Form\TicketAwareTrait;

class SendMessageInputForm extends BaseSendMessageForm implements SendMessageInputInterface
{
    use TicketAwareTrait;

    public function rules()
    {
        return array_merge(
            $this->getModelRulesByFields(MessageInterface::class, ['ticket_id']),
            parent::rules()
        );
    }

    public function getTicket_id()
    {
        return $this->getTicket()->getId();
    }
}
