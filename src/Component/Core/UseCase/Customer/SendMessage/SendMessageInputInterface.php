<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\Entity\TicketInterface;

interface SendMessageInputInterface
{
    public function getTicket(): TicketInterface;

    public function getCustomer(): CustomerInterface;

    public function getText(): string;

    /** @return AttachmentInterface[] */
    public function getAttachments(): iterable;
}
