<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

use Support\Component\Core\Entity\AttachmentInterface;
use Support\Component\Core\Entity\UserInterface;

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
