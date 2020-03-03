<?php

namespace SSupport\Module\Core\UseCase\Form;

interface AttachmentUploadSettingsInterface extends FileAcceptAwareInterface
{
    public function getRules(): array;

    public function getMimeType(): array;
}
