<?php

namespace SSupport\Component\Core\UseCase\Customer\SendMessage;

use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\Entity\TicketInterface;

class SendMessageInput implements SendMessageInputInterface
{
    protected $ticket;
    protected $customer;
    protected $text;
    protected $attachments;

    public function __construct(
        TicketInterface $ticket,
        CustomerInterface $customer,
        string $text,
        iterable $attachments = null
    ) {
        $this->ticket = $ticket;
        $this->customer = $customer;
        $this->text = $text;
        $this->attachments = $attachments;
    }

    public function getTicket(): TicketInterface
    {
        return $this->ticket;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
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
