<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

interface BeforeSendMessageInterface
{
    public function getInput(): SendMessageInputInterface;
}
