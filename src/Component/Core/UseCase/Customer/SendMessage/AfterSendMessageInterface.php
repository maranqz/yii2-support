<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\UseCase\InputAwareInterface;

interface AfterSendMessageInterface extends InputAwareInterface
{
    public function getInput(): SendMessageInputInterface;

    public function getMessage(): MessageInterface;
}
