<?php

namespace SSupport\Module\Core\Gateway\Highlighting;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface HighlighterInterface
{
    /**
     * @param $ticket
     * @param UserInterface[] $excludeUsers
     *
     * @return mixed
     */
    public function highlight(TicketInterface $ticket, iterable $excludeUsers = []);

    public function hasHighlight(TicketInterface $ticket, UserInterface $user): bool;

    public function removeHighlight(TicketInterface $ticket, UserInterface $user);
}
