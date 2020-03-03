<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use yii\web\Controller;

interface RedirectAfterCreateTicketInterface
{
    public function __invoke(Controller $controller, TicketInterface $ticket);
}
