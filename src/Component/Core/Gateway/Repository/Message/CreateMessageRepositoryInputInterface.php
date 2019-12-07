<?php

namespace SSupport\Component\Core\Gateway\Repository\Message;

interface CreateMessageRepositoryInputInterface
{
    public function getText();

    public function getAttachments();

    public function getSender();
}
