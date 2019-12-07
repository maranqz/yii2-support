<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

interface BeforeSendMessageInterface
{
    public function getInput(): SendMessageInputInterface;
}
