<?php

namespace SSupport\Component\Core\Gateway\Repository\Message;

use SSupport\Component\Core\Entity\UserInterface;

class CreateMessageRepositoryInput implements CreateMessageRepositoryInputInterface
{
    private $text;
    private $attachments;
    private $sender;

    public function __construct(string $text, UserInterface $sender, iterable $attachments)
    {
        $this->text = $text;
        $this->sender = $sender;
        $this->attachments = $attachments;
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
}
