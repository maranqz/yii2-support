<?php

namespace SSupport\Module\Core\UseCase\Form;

class AttachmentUploadSettings implements AttachmentUploadSettingsInterface
{
    protected $rules;
    protected $mimeTypes;

    public function __construct(array $rules, array $mimeTypes)
    {
        $this->rules = $rules;
        $this->mimeTypes = $mimeTypes;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getMimeType(): array
    {
        return $this->mimeTypes;
    }

    public function getAcceptType(): string
    {
        return implode(',', $this->mimeTypes);
    }
}
