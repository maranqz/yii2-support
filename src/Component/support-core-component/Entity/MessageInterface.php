<?php

namespace Support\Component\Core\Entity;

use Doctrine\Common\Collections\Collection;
use Support\Component\Core\Entity\Utils\CreatedAtInterface;
use Support\Component\Core\Entity\Utils\IdentifyInterface;

interface MessageInterface extends IdentifyInterface, CreatedAtInterface
{
    public function getText(): string;

    public function setText(string $text): self;

    /**
     * @return Collection|AttachmentInterface[]
     */
    public function getAttachments(): iterable;

    public function addAttachment(AttachmentInterface $attachment): self;

    public function getSender(): UserInterface;

    public function setSender(UserInterface $sender, bool $isCustomer): self;

    public function isCustomerSent(): bool;

    public function isAgentSent(): bool;
}
