<?php

namespace SSupport\Component\Core\Gateway\Uploader;

final class DefaultAttachmentPathGenerator implements AttachmentPathGeneratorInterface
{
    public function generate(string $path): string
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext) {
            $ext = '.'.$ext;
        }

        $hash = bin2hex(random_bytes(8));

        return $this->addDataToPath($hash.$ext);
    }

    private function addDataToPath(string $path): string
    {
        return date('y/m/d').$path;
    }
}
