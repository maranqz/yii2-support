<?php

namespace SSupport\Component\Core\Factory\Message;

interface CreateMessageInputInterface
{
    public function getText();

    public function getAttachments();

    public function getSender();
}
