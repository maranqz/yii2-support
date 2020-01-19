<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class AfterSendMessage extends StoppableEvent implements AfterSendMessageInterface
{
    protected $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
