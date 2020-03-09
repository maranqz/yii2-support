<?php

namespace SSupport\Component\Core\Gateway\Uploader;

final class DefaultAttachmentPathGenerator implements AttachmentPathGeneratorInterface
{
    protected $randomByteLength;

    public function __construct($randomByteLength = 8)
    {
        $this->randomByteLength = $randomByteLength;
    }

    public function generate(string $path): string
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext) {
            $ext = '.' . $ext;
        }

        $hash = bin2hex(random_bytes($this->randomByteLength));

        return $this->addDataToPath($hash . $ext);
    }

    private function addDataToPath(string $path): string
    {
        return date('y/m/d') . '/' . $path;
    }
}
