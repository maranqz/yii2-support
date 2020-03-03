<?php

namespace SSupport\Module\Core\UseCase\Form;

use SSupport\Module\Core\Gateway\Uploader\UploadFileConverterAttachmentInterface;
use yii\web\UploadedFile;

trait AttachmentUploadsTrait
{
    protected $_files;

    /**
     * Before using {@see getAttachments} and {@see getAttachmentUploads}
     * call {@see loadFiles} or {@see load}.
     *
     * @var UploadFileConverterAttachmentInterface
     */
    protected $converter;

    public function load($data, $formName = null)
    {
        return $this->loadForm($data, $formName);
    }

    protected function loadForm($data, $formName = null)
    {
        return parent::load($data, $formName) && $this->loadFiles();
    }

    protected function loadFiles()
    {
        $this->setFiles(UploadedFile::getInstances($this, 'files'));
        $this->converter = $this->make(
            UploadFileConverterAttachmentInterface::class,
            [$this->getFiles()]
        );

        return $this;
    }

    protected function setFiles(iterable $files)
    {
        $this->_files = $files;

        return $this;
    }

    /** @return UploadedFile[] */
    public function getFiles()
    {
        return $this->_files;
    }

    public function getAttachments(): iterable
    {
        return $this->converter->getAttachments();
    }

    public function getAttachmentUploads(): iterable
    {
        return $this->converter->getAttachmentUploads();
    }
}
