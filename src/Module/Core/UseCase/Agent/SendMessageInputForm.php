<?php

namespace SSupport\Module\Core\UseCase\Agent;

use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Core\UseCase\Agent\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\UseCase\Form\AbstractSendMessageInputForm as BaseSendMessageForm;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsAwareTrait;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadsTrait;
use SSupport\Module\Core\UseCase\Form\FileAcceptAwareInterface;
use SSupport\Module\Core\UseCase\Form\TicketAwareTrait;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

class SendMessageInputForm extends BaseSendMessageForm implements SendMessageInputInterface, AttachmentUploadsAwareInterface, FileAcceptAwareInterface
{
    use AttachmentUploadSettingsAwareTrait;
    use AttachmentUploadsTrait;
    use ContainerAwareTrait;
    use TicketAwareTrait;

    protected $agent;

    public function __construct(
        AttachmentUploadSettingsInterface $attachmentUploadSettings,
        $config = []
    ) {
        parent::__construct($config);

        $this->attachmentUploadSettings = $attachmentUploadSettings;
    }

    public function getAgent(): UserInterface
    {
        return $this->agent;
    }

    public function setAgent(UserInterface $agent)
    {
        $this->agent = $agent;

        return $this;
    }
}
