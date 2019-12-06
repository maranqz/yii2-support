<?php

namespace Support\Component\Core\UseCase\Customer\SendMessage;

interface BeforeSendMessageInterface
{
    public function getInput(): SendMessageInputInterface;
}
