<?php

namespace SSupport\Component\Core\Entity;

use Doctrine\Common\Collections\Collection;
use SSupport\Component\Core\Entity\Utils\CreatedAtInterface;
use SSupport\Component\Core\Entity\Utils\IdentifyInterface;

interface MessageInterface extends IdentifyInterface, CreatedAtInterface
{
    public function getText(): string;

    /** @return Collection|AttachmentInterface[] */
    public function getAttachments(): iterable;

    public function addAttachments(iterable $attachments): self;

    public function addAttachment(AttachmentInterface $attachment): self;

    public function getSender(): UserInterface;
}
