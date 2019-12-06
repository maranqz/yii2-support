<?php

namespace Support\Component\Referee\UseCase\Referee\SendMessage;

use Support\Component\Core\Entity\AttachmentInterface;
use Support\Component\Referee\Entity\RefereeInterface;
use Support\Component\Referee\Entity\RefereeTicketInterface;

interface SendMessageInputInterface
{
    public function getTicket(): RefereeTicketInterface;

    public function getReferee(): RefereeInterface;

    public function getText(): string;

    /** @return AttachmentInterface[] */
    public function getAttachments(): iterable;
}
