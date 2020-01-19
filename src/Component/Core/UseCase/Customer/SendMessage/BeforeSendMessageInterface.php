<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\UseCase\InputAwareInterface;

interface BeforeSendMessageInterface extends InputAwareInterface
{
    public function getInput(): SendMessageInputInterface;
}
