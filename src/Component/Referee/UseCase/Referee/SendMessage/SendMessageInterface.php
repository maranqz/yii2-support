<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Entity\MessageInterface;

interface SendMessageInterface
{
    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface;
}
