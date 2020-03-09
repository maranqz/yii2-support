<?php

namespace SSupport\Component\Core\Gateway\Uploader;

interface AttachmentUploadInterface
{
    /** @return resource */
    public function getStream();

    public function getPath(): string;

    public function getName(): string;
}
