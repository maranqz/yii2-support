<?php

namespace Support\Component\Core\UseCase\Agent\SendMessage;

use Support\Component\Core\Entity\MessageInterface;

interface AfterSendMessageInterface
{
    public function getMessage(): MessageInterface;
}
