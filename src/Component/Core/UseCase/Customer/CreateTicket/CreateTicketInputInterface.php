<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\CustomerInterface;

interface CreateTicketInputInterface
{
    public function getCustomer(): CustomerInterface;

    public function getSubject(): string;

    public function getText(): string;

    /**
     * @return AttachmentInterface[]
     */
    public function getAttachments(): iterable;
}
