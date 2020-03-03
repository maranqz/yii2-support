<?php

namespace SSupport\Module\Core\Gateway\Uploader;

use League\Flysystem\FilesystemInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentPathGeneratorInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadInterface;
use SSupport\Component\Core\Gateway\Uploader\UploaderInterface;

class Uploader implements UploaderInterface
{
    protected $filesystem;
    protected $pathGenerator;

    public function __construct(
        FilesystemInterface $filesystem,
        AttachmentPathGeneratorInterface $pathGenerator
    ) {
        $this->filesystem = $filesystem;
        $this->pathGenerator = $pathGenerator;
    }

    public function upload(AttachmentUploadInterface $attachmentUpload)
    {
        $this->filesystem->writeStream(
            $attachmentUpload->getName(),
            $attachmentUpload->getStream()
        );
    }

    public function remove(string $path): bool
    {
        if ($this->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }
}
