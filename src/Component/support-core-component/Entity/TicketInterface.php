<?php

namespace Support\Component\Core\Entity;

use Doctrine\Common\Collections\Collection;
use Support\Component\Core\Entity\Utils\CustomerAwareInterface;
use Support\Component\Core\Entity\Utils\IdentifyInterface;
use Support\Component\Core\Entity\Utils\TimestampInterface;

interface TicketInterface extends IdentifyInterface, CustomerAwareInterface, TimestampInterface
{
    public function getSubject(): string;

    public function setSubject(string $subject): self;

    /**
     * @return Collection|MessageInterface[]
     */
    public function getMessages(): iterable;

    public function addMessage(MessageInterface $message): self;

    /**
     * @return Collection|UserInterface[]
     */
    public function getAssigns(): iterable;

    public function assign(UserInterface $user): self;

    public function deassign(UserInterface $user): self;
}
