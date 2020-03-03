<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Gateway\Event\StoppableEvent;

class BeforeSendMessage extends StoppableEvent implements BeforeSendMessageInterface
{
    protected $inputDTO;

    public function __construct(SendMessageInputInterface $inputDTO)
    {
        $this->inputDTO = $inputDTO;
    }

    public function getInput(): SendMessageInputInterface
    {
        return $this->inputDTO;
    }
}
