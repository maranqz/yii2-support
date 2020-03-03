<?php

namespace SSupport\Component\Core\Gateway\Uploader;

interface AttachmentUploadsAwareInterface
{
    /**  @return AttachmentUploadInterface[] */
    public function getAttachmentUploads(): iterable;
}
