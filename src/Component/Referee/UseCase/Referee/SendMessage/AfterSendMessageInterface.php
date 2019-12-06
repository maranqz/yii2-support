<?php

namespace Support\Component\Referee\UseCase\Referee\SendMessage;

use Support\Component\Core\Entity\MessageInterface;

interface AfterSendMessageInterface
{
    public function getMessage(): MessageInterface;
}
