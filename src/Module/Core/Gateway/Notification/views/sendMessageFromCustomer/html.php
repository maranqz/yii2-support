<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Controller\customer\ticket\IndexController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $ticket TicketInterface */
/* @var $message MessageInterface */

echo $this->render('../commonHtml', [
    'ticket' => $ticket,
    'message' => $message,
    'link' => Html::a(
        Yii::t('ssupport_core', 'message_link'),
        null,
        [
            'href' => Url::to([IndexController::PATH . '/view', 'ticketId' => $ticket->getId()], true),
        ]
    ),
]);
