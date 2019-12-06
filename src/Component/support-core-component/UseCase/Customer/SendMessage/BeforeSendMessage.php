<?php

namespace Support\Component\Core\UseCase\Customer\SendMessage;

use Support\Component\Core\Gateway\Event;

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
