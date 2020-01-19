<?php

namespace SSupport\Module\Core\Gateway\Uploader;

use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Core\Gateway\Uploader\UploaderInterface;
use SSupport\Component\Core\UseCase\InputAwareInterface;

class AttachmentUploadListener
{
    protected $uploader;

    public function __construct(UploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function __invoke(object $event)
    {
        if ($this->eventAttachmentUploadsAware($event)) {
            return $event;
        }

        /** @var AttachmentUploadsAwareInterface $input */
        $input = $event->getInput();

        foreach ($input->getAttachmentUploads() as $attachmentUpload) {
            $this->uploader->upload($attachmentUpload);
        }

        return $event;
    }

    protected function eventAttachmentUploadsAware($event)
    {
        return !$event instanceof InputAwareInterface
            || !$event->getInput() instanceof AttachmentUploadsAwareInterface;
    }
}
