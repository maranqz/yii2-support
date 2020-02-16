<?php

namespace SSupport\Component\Referee\Gateway\Repository;

use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

abstract class AbstractRefereeUserRepository implements RefereeUserRepositoryInterface
{
    /** @var GetRefereeForTicketInterface */
    protected $getRefereeForTicket;

    public function __construct(GetRefereeForTicketInterface $getRefereeForTicket)
    {
        $this->getRefereeForTicket = $getRefereeForTicket;
    }

    public function getRefereeForTicket(RefereeTicketInterface $ticket): RefereeInterface
    {
        return ($this->getRefereeForTicket)($ticket);
    }
}
