<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;

interface AfterSendMessageInterface
{
    public function getMessage(): MessageInterface;
}
