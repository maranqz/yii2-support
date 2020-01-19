<?php

namespace SSupport\Component\Core\Gateway\Uploader;

interface AttachmentUploadInterface
{
    /** @return resource */
    public function getStream();

    public function getName(): string;
}
