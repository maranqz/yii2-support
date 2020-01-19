<?php

namespace SSupport\Module\Core\Gateway\Filesystem;

interface UrlAdapterInterface
{
    public function getUrl(string $key): string;
}
