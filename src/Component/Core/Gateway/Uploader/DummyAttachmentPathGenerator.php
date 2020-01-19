<?php

namespace SSupport\Component\Core\Gateway\Uploader;

final class DummyAttachmentPathGenerator implements AttachmentPathGeneratorInterface
{
    public function generate(string $path): string
    {
        return $path;
    }
}
