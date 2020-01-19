<?php

namespace SSupport\Module\Core\Gateway\Uploader;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentPathGeneratorInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use yii\web\UploadedFile;

class UploadFileConverterAttachment implements UploadFileConverterAttachmentInterface
{
    use ContainerAwareTrait;

    protected $upload;
    protected $pathGenerator;

    protected $isLoaded = false;
    protected $attachments;
    protected $attachmentUploads;

    /**
     * @param UploadedFile[] $upload
     */
    public function __construct(iterable $upload, AttachmentPathGeneratorInterface $pathGenerator)
    {
        $this->upload = $upload;
        $this->pathGenerator = $pathGenerator;
    }

    /**
     * @return AttachmentInterface[]
     */
    public function getAttachments(): iterable
    {
        $this->loadAttachmentsAndUploads();

        return $this->attachments;
    }

    /**
     * @return AttachmentUploadInterface[]
     */
    public function getAttachmentUploads(): iterable
    {
        $this->loadAttachmentsAndUploads();

        return $this->attachmentUploads;
    }

    protected function loadAttachmentsAndUploads()
    {
        if ($this->isLoaded) {
            return;
        }

        $attachments = [];
        $attachmentUploads = [];
        foreach ($this->upload as $file) {
            $path = $this->pathGenerator->generate($file->name);

            $attachments[] = $this->make(AttachmentInterface::class, [], [
                'path' => $path,
                'name' => $file->name,
                'size' => $file->size,
            ]);

            $attachmentUploads[] = $this->make(
                AttachmentUploadInterface::class,
                [
                    fopen($file->tempName, 'r'),
                    $path,
                ]
            );
        }

        $this->attachments = $attachments;
        $this->attachmentUploads = $attachmentUploads;
        $this->isLoaded = true;
    }
}
