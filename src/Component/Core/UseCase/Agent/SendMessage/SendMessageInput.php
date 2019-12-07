<?php

namespace SSupport\Component\Core\UseCase\Agent\SendMessage;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

class SendMessageInput implements SendMessageInputInterface
{
    protected $ticket;
    protected $agent;
    protected $text;
    protected $attachments;

    public function __construct(
        TicketInterface $ticket,
        UserInterface $agent,
        string $text,
        iterable $attachments = null
    ) {
        $this->ticket = $ticket;
        $this->agent = $agent;
        $this->text = $text;
        $this->attachments = $attachments;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }

    public function getAgent(): UserInterface
    {
        return $this->agent;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAttachments(): iterable
    {
        return $this->attachments;
    }
}
