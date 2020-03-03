<?php

namespace SSupport\Module\Core\UseCase\Form;

trait AttachmentUploadSettingsAwareTrait
{
    /** @var AttachmentUploadSettingsInterface */
    protected $attachmentUploadSettings;

    public function getAcceptType(): string
    {
        return $this->attachmentUploadSettings->getAcceptType();
    }
}
