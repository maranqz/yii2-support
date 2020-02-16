<?php

namespace SSupport\Module\Referee\UseCase\Referee;

use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\UseCase\Form\AbstractSendMessageInputForm as BaseSendMessageForm;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsAwareTrait;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadsTrait;
use SSupport\Module\Core\UseCase\Form\FileAcceptAwareInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

class SendMessageInputForm extends BaseSendMessageForm implements SendMessageInputInterface, AttachmentUploadsAwareInterface, FileAcceptAwareInterface
{
    use ContainerAwareTrait;
    use AttachmentUploadsTrait;
    use AttachmentUploadSettingsAwareTrait;

    protected $referee;
    protected $ticket;

    public function __construct(
        AttachmentUploadSettingsInterface $attachmentUploadSettings,
        $config = []
    ) {
        parent::__construct($config);

        $this->attachmentUploadSettings = $attachmentUploadSettings;
    }

    public function getReferee(): RefereeInterface
    {
        return $this->referee;
    }

    public function setReferee(RefereeInterface $referee)
    {
        $this->referee = $referee;

        return $this;
    }

    public function setTicket(RefereeTicketInterface $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getTicket(): RefereeTicketInterface
    {
        return $this->ticket;
    }
}
