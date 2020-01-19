<?php

namespace SSupport\Component\Core\Gateway\Uploader;

final class AttachmentUpload implements AttachmentUploadInterface
{
    private $stream;
    private $name;

    public function __construct($stream, string $name)
    {
        $this->stream = $stream;
        $this->name = $name;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
