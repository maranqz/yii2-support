<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\UseCase\InputAwareInterface;

interface AfterSendMessageInterface extends InputAwareInterface
{
    public function getInput(): SendMessageInputInterface;

    public function getMessage(): MessageInterface;
}
