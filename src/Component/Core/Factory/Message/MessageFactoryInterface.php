<?php

namespace SSupport\Component\Core\Factory\Message;

use SSupport\Component\Core\Entity\MessageInterface;

interface MessageFactoryInterface
{
    public function create(CreateMessageInput $input): MessageInterface;
}
