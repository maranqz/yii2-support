<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Controller\customer\ticket\IndexController;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $ticket TicketInterface */
/* @var $message MessageInterface */

echo $this->render('../commonText', [
    'ticket' => $ticket,
    'message' => $message,
    'link' => Url::to([IndexController::PATH . '/view', 'ticketId' => $ticket->getId()], true),
]);
