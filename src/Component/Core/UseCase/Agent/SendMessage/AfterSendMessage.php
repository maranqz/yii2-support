<?php

namespace Support\Component\Core\UseCase\Agent\SendMessage;

use Support\Component\Core\Entity\MessageInterface;
use Support\Component\Core\Gateway\Event;

class AfterSendMessage extends Event implements AfterSendMessageInterface
{
    protected $message;

    public function __construct(MessageInterface $message
) {
        $this->message = $message;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
