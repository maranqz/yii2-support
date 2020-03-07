<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Referee\Controller\customer\referee\IndexController;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $ticket TicketInterface */
/* @var $message MessageInterface */

echo $this->render('@SSupport/Module/Core/Gateway/Notification/views/commonText', [
    'ticket' => $ticket,
    'message' => $message,
    'link' => Url::to([IndexController::PATH . '/view', 'ticketId' => $ticket->getId()], true),
]);
