<?php

namespace SSupport\Module\Referee\Entity;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Module\Core\Entity\Ticket;

class RefereeTicketExample extends Ticket implements RefereeTicketInterface
{
    use RefereeTicketTrait;
}
