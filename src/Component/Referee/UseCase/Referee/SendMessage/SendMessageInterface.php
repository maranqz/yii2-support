<?php

namespace Support\Component\Referee\UseCase\Referee\SendMessage;

use Support\Component\Core\Entity\MessageInterface;

interface SendMessageInterface
{
    public function __invoke(SendMessageInputInterface $inputDTO): MessageInterface;
}
