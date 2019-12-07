<?php

namespace SSupport\Component\Core\UseCase\Agent\SendMessage;

interface BeforeSendMessageInterface
{
    public function getInput(): SendMessageInputInterface;
}
