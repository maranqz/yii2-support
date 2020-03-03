<?php

namespace SSupport\Module\Core\Resource\Widget\AttachmentPath;

use SSupport\Module\Core\Gateway\Filesystem\UrlAdapterInterface;
use yii\base\Widget;

class AttachmentPathWidget extends Widget
{
    /** @var string */
    public $path;
    private $urlAdapter;

    public function __construct(UrlAdapterInterface $urlAdapter, $config = [])
    {
        parent::__construct($config);

        $this->urlAdapter = $urlAdapter;
    }

    public function init()
    {
        parent::init();

        \assert(
            !empty($this->path),
            new \InvalidArgumentException('$key should be set')
        );
    }

    public function run()
    {
        return $this->urlAdapter->getUrl($this->path);
    }
}
