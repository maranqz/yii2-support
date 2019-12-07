<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;

interface SendMessageInterface
{
    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface;
}
