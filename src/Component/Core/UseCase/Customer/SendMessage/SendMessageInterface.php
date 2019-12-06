<?php

namespace Support\Component\Core\UseCase\Customer\SendMessage;

use Support\Component\Core\Entity\MessageInterface;

interface SendMessageInterface
{
    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface;
}