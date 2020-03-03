<?php

namespace SSupport\Module\Referee\Entity;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\Entity\TimeoutRequestRefereeInterface;
use SSupport\Module\Core\Entity\Ticket;

class RefereeTicketExample extends Ticket implements RefereeTicketInterface, TimeoutRequestRefereeInterface
{
    use RefereeTicketTrait;
    use TimeoutRequestRefereeTrait;
}
