<?php

namespace SSupport\Module\Core\UseCase\Customer;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\UseCase\Form\AbstractSendMessageInputForm as BaseSendMessageForm;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsAwareTrait;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadsTrait;
use SSupport\Module\Core\UseCase\Form\FileAcceptAwareInterface;
use SSupport\Module\Core\UseCase\Form\TicketAwareTrait;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

class SendMessageInputForm extends BaseSendMessageForm implements SendMessageInputInterface, AttachmentUploadsAwareInterface, FileAcceptAwareInterface
{
    use ContainerAwareTrait;
    use TicketAwareTrait;
    use AttachmentUploadsTrait;
    use AttachmentUploadSettingsAwareTrait;

    protected $customer;

    public function __construct(
        AttachmentUploadSettingsInterface $attachmentUploadSettings,
        $config = []
    ) {
        parent::__construct($config);

        $this->attachmentUploadSettings = $attachmentUploadSettings;
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
}