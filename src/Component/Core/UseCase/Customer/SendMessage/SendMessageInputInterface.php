<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface SendMessageInputInterface
{
    public function getTicket(): TicketInterface;

    public function getCustomer(): UserInterface;

    public function getText(): string;

    /** @return AttachmentInterface[] */
    public function getAttachments(): iterable;
}
