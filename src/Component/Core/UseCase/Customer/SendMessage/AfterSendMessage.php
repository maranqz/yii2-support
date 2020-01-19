<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class AfterSendMessage extends StoppableEvent implements AfterSendMessageInterface
{
    protected $input;
    protected $message;

    public function __construct(SendMessageInputInterface $input, MessageInterface $message)
    {
        $this->input = $input;
        $this->message = $message;
    }

    public function getInput(): SendMessageInputInterface
    {
        return $this->input;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
