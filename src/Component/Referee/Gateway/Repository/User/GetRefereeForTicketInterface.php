<?php

namespace SSupport\Component\Referee\Gateway\Repository\User;

use SSupport\Component\Referee\Entity\RefereeInterface;
use SSupport\Component\Referee\Entity\RefereeTicketInterface;

interface GetRefereeForTicketInterface
{
    public function __invoke(RefereeTicketInterface $ticket): RefereeInterface;
}
