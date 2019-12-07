<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Gateway\Event;

class BeforeSendMessage extends Event implements BeforeSendMessageInterface
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
