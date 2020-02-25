<?php

namespace SSupport\Module\Core\Gateway\Highlighting;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Gateway\Repository\TicketRepositoryInterface;

class Highlighter implements HighlighterInterface
{
    protected $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @param $ticket
     * @param UserInterface[] $excludeUsers
     */
    public function highlight(TicketInterface $ticket, iterable $excludeUsers = [])
    {
        $ticket->clearReaders();
        foreach ($excludeUsers as $excludeUser) {
            $ticket->addReader($excludeUser);
        }

        $this->ticketRepository->save($ticket);
    }

    public function hasHighlight(TicketInterface $ticket, UserInterface $user): bool
    {
        return $ticket->isReader($user);
    }

    public function removeHighlight(TicketInterface $ticket, UserInterface $user)
    {
        $ticket->addReader($user);

        $this->ticketRepository->save($ticket);
    }
}
