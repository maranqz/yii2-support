<?php

namespace Support\Component\Referee\UseCase\Referee\SendMessage;

interface BeforeSendMessageInterface
{
    public function getInput(): SendMessageInputInterface;
}
