<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Module;
use Yii;
use yii\web\Controller;

class RedirectAfterCreateTicket implements RedirectAfterCreateTicketInterface
{
    public function __invoke(Controller $controller, TicketInterface $ticket)
    {
        if (Yii::$app->user->isGuest) {
            return $controller->redirect(['after-create', Module::TICKET_ID => $ticket->getId()]);
        }

        return $controller->redirect(['view', Module::TICKET_ID => $ticket->getId()]);
    }
}
