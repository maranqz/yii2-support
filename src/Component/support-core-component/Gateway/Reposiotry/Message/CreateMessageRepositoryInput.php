<?php

namespace Support\Component\Core\Gateway\Repository\Message;

use Support\Component\Core\Entity\UserInterface;

class CreateMessageRepositoryInput implements CreateMessageRepositoryInputInterface
{
    private $text;
    private $attachments;
    private $sender;
    private $isCustomSent;

    public function __construct(string $text, UserInterface $sender, iterable $attachments, bool $isCustomSent)
    {
        $this->text = $text;
        $this->sender = $sender;
        $this->attachments = $attachments;
        $this->isCustomSent = $isCustomSent;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function isCustomerSent()
    {
        return $this->isCustomSent;
    }
}
