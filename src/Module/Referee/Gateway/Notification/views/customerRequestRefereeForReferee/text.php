<?php

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Referee\Controller\customer\referee\IndexController;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $ticket TicketInterface */

echo Yii::t(
    'ssupport_referee',
    'notifier_referee_request_txt',
    [
        'nickname' => $ticket->getCustomer()->getNickname(),
        'subject' => $ticket->getSubject(),
        'link' => Url::to([IndexController::PATH.'/view', 'ticketId' => $ticket->getId()], true),
    ]);
