<?php

namespace SSupport\Component\Core\UseCase\Agent\SendMessage;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class BeforeSendMessage extends StoppableEvent implements BeforeSendMessageInterface
{
    protected $input;

    public function __construct(SendMessageInputInterface $input)
    {
        $this->input = $input;
    }

    public function getInput(): SendMessageInputInterface
    {
        return $this->input;
    }
}
