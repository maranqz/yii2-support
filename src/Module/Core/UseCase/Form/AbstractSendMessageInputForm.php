<?php

namespace SSupport\Module\Core\UseCase\Form;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\ModelGetRulesTrait;
use yii\base\Model;
use yii\web\UploadedFile;

abstract class AbstractSendMessageInputForm extends Model
{
    use ContainerAwareTrait;
    use ModelGetRulesTrait;

    public $text;

    public $filesMimeTypes = 'text/plain';

    protected $ticket;
    protected $_files;
    protected $customer;
    protected $attachments = [];

    public function rules()
    {
        return array_merge(
            $this->getModelRulesByFields(MessageInterface::class, ['text']),
            [
                [['files'], 'file', 'maxFiles' => '5', 'mimeTypes' => $this->filesMimeTypes],
            ]
        );
    }

    public function setTicket(TicketInterface $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }

    public function getCustomer(): UserInterface
    {
        return $this->customer;
    }

    public function setCustomer(UserInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAttachments(): iterable
    {
        return $this->attachments;
    }

    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) && $this->loadAttachments();
    }

    protected function loadAttachments()
    {
        $this->setFiles(UploadedFile::getInstances($this, 'files'));
        $this->setAttachments();

        return $this;
    }

    protected function setFiles(iterable $files)
    {
        $this->_files = $files;

        return $this;
    }

    protected function setAttachments()
    {
        $attachments = [];
        foreach ($this->getFiles() as $file) {
            $attachments[] = $this->make(AttachmentInterface::class, [], [
                'path' => $file->getBaseName().'.'.microtime(true).'.'.$file->getExtension(),
                'size' => $file->size,
            ]);
        }

        $this->attachments = $attachments;
    }

    /** @return UploadedFile[] */
    public function getFiles()
    {
        return $this->_files;
    }
}
