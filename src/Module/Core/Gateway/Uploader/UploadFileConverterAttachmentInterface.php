<?php

namespace SSupport\Module\Core\Gateway\Uploader;

interface UploadFileConverterAttachmentInterface
{
    public function getAttachments(): iterable;

    public function getAttachmentUploads(): iterable;
}
