<?php

namespace SSupport\Module\Core\Factory\Message;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Factory\Message\CreateMessageInput;
use SSupport\Component\Core\Factory\Message\MessageFactoryInterface;
use SSupport\Module\Core\Entity\Message;
use SSupport\Module\Core\Utils\ContainerAwareTrait;

class MessageFactory implements MessageFactoryInterface
{
    use ContainerAwareTrait;

    public function create(CreateMessageInput $input): MessageInterface
    {
        /** @var Message $message */
        $message = $this->make(MessageInterface::class);

        $message->setText($input->getText())
            ->setSender($input->getSender())
            ->addAttachments($input->getAttachments());

        return $message;
    }
}
