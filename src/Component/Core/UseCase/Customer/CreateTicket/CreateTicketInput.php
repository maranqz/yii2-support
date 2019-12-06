<?php

namespace Support\Component\Core\UseCase\Customer\CreateTicket;

use Support\Component\Core\Entity\UserInterface;

class CreateTicketInput implements CreateTicketInputInterface
{
    protected $customer;
    protected $agents;
    protected $subject;
    protected $text;
    protected $attachments;

    public function __construct(UserInterface $customer, iterable $agents, $subject, $text, iterable $attachments = null)
    {
        $this->customer = $customer;
        $this->agents = $agents;
        $this->subject = $subject;
        $this->text = $text;
        $this->attachments = $attachments;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getAgents()
    {
        return $this->agents;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }
}
