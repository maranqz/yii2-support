<?php

namespace SSupport\Component\Referee\Entity;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;

interface RefereeTicketInterface extends TicketInterface
{
    public function getReferee(): ?RefereeInterface;

    public function assignReferee(RefereeInterface $user, UserInterface $requester = null);

    public function deAssignReferee(RefereeInterface $user);

    public function hasReferee(): bool;
}
