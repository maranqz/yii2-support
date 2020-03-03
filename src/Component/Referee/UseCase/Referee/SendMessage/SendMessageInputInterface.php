<?php

namespace SSupport\Component\Referee\UseCase\Referee\SendMessage;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface SendMessageInputInterface
{
    public function getTicket(): RefereeTicketInterface;

    public function getReferee(): RefereeInterface;

    public function getText(): string;

    /** @return AttachmentInterface[] */
    public function getAttachments(): iterable;
}
