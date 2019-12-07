<?php

namespace SSupport\Component\Core\UseCase\Customer\CreateTicket;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface CreateTicketInputInterface
{
    /**
     * @return UserInterface
     */
    public function getCustomer();

    public function getSubject();

    public function getText();

    /**
     * @return AttachmentInterface[]
     */
    public function getAttachments();
}
