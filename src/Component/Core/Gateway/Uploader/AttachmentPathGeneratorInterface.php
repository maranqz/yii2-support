<?php

namespace SSupport\Component\Core\Gateway\Uploader;

interface AttachmentPathGeneratorInterface
{
    public function generate(string $path): string;
}
