<?php

namespace Support\Component\Core\UseCase\Customer\SendMessage;

use Support\Component\Core\Entity\AttachmentInterface;
use Support\Component\Core\Entity\TicketInterface;
use Support\Component\Core\Entity\UserInterface;

interface SendMessageInputInterface
{
    public function getTicket(): TicketInterface;

    public function getCustomer(): UserInterface;

    public function getText(): string;

    /** @return AttachmentInterface[] */
    public function getAttachments(): iterable;
}
