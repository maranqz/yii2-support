<?php

namespace SSupport\Component\Core\Gateway\Uploader;

final class AttachmentUpload implements AttachmentUploadInterface
{
    private $stream;
    private $path;
    private $name;

    public function __construct($stream, string $path, string $name = null)
    {
        $this->stream = $stream;
        $this->path = $path;

        if (empty($name)) {
            $name = basename($this->path);
        }

        $this->name = $name;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
