<?php

namespace SSupport\Component\Core\Gateway\Uploader;

interface UploaderInterface
{
    public function upload(AttachmentUploadInterface $attachmentUpload);

    public function remove(string $path);
}
