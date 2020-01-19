<?php

namespace SSupport\Module\Core\UseCase\Customer;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsAwareTrait;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadsTrait;
use SSupport\Module\Core\UseCase\Form\FileAcceptAwareInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\ModelGetRulesTrait;
use yii\base\Model;

class CreateTicketForm extends Model implements CreateTicketInputInterface, AttachmentUploadsAwareInterface, FileAcceptAwareInterface
{
    use ContainerAwareTrait;
    use ModelGetRulesTrait;
    use AttachmentUploadsTrait;
    use AttachmentUploadSettingsAwareTrait;

    public $subject;
    public $text;

    protected $customer;

    public function __construct(
        AttachmentUploadSettingsInterface $attachmentUploadSettings,
        $config = []
    ) {
        parent::__construct($config);

        $this->attachmentUploadSettings = $attachmentUploadSettings;
    }

    public function rules()
    {
        $rules = array_merge(
            $this->getModelRulesByFields(TicketInterface::class, ['subject']),
            $this->getModelRulesByFields(MessageInterface::class, ['text']),
            $this->attachmentUploadSettings->getRules()
        );

        return $rules;
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
}
