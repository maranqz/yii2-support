<?php

namespace Support\Component\Core\Gateway\Repository\Message;

use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Core\Gateway\Repository\RepositoryInterface;

interface MessageRepositoryInterface extends RepositoryInterface
{
    public function createAndSave(CreateMessageRepositoryInputInterface $messageInput): MessageInterface;

    public function save(MessageInterface $ticket): MessageInterface;
}
