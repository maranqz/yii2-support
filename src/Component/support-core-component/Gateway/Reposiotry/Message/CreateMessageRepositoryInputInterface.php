<?php

namespace Support\Component\Core\Gateway\Repository\Message;

interface CreateMessageRepositoryInputInterface
{
    public function getText();

    public function getAttachments();

    public function getSender();

    public function isCustomerSent();
}
