<?php

namespace SSupport\Module\Core\UseCase\Customer;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\ModelGetRulesTrait;
use yii\base\Model;

class CreateTicketForm extends Model implements CreateTicketInputInterface
{
    use ContainerAwareTrait;
    use ModelGetRulesTrait;

    public $subject;
    public $text;
    protected $customer;
    protected $attachments;

    public function rules()
    {
        return array_merge(
            $this->getModelRulesByFields(TicketInterface::class, ['subject']),
            $this->getModelRulesByFields(MessageInterface::class, ['text'])
        );
    }

    public function getCustomer(): UserInterface
    {
        return $this->customer;
    }

    public function setCustomer(UserInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAttachments(): iterable
    {
        return $this->attachments;
    }

    /** @param AttachmentInterface[] $attachments */
    public function setAttachments(iterable $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
