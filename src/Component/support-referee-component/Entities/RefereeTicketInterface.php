<?php

namespace Support\Component\Referee\Entity;

use Doctrine\Common\Collections\Collection;
use Support\Component\Core\Entity\TicketInterface;

interface RefereeTicketInterface extends TicketInterface
{
    /**
     * @return Collection|RefereeInterface[]
     */
    public function getReferees(): iterable;

    public function assignReferee(RefereeInterface $user);

    public function deassignReferee(RefereeInterface $user);
}
