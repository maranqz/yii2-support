<?php

namespace SSupport\Module\Core\Gateway\Filesystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use SplFileInfo;

class LocalUrlAdapter implements UrlAdapterInterface
{
    private $root;
    /** @var Local */
    private $adapter;

    public function __construct(string $root, AdapterInterface $adapter)
    {
        $this->root = $root;
        $this->adapter = $adapter;
    }

    public function getUrl(string $key): string
    {
        /** @var SplFileInfo $file */
        $file = $this->adapter->getMetadata($key);

        return $this->root.$file['path'];
    }
}
