<?php

namespace SSupport\Component\Core\Gateway\Repository\Message;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Gateway\Repository\RepositoryInterface;

interface MessageRepositoryInterface extends RepositoryInterface
{
    public function createAndSave(CreateMessageRepositoryInputInterface $messageInput): MessageInterface;

    public function save(MessageInterface $ticket): MessageInterface;
}
