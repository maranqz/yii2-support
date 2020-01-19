<?php

namespace SSupport\Module\Core\Gateway\Filesystem;

use League\Flysystem\AdapterInterface;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class S3v3UrlAdapter implements UrlAdapterInterface
{
    /** @var AwsS3Adapter */
    private $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getUrl(string $key): string
    {
        /** @var AwsS3Adapter $client */
        $client = $this->adapter->getClient();

        return $client->getObjectUrl($this->adapter->getBucket(), $key);
    }
}
