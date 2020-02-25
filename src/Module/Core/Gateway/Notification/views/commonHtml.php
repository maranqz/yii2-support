<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use yii\web\View;

/* @var $this View */
/* @var $ticket TicketInterface */
/* @var $message MessageInterface */
/* @var $link string */

echo Yii::t(
    'ssupport_core',
    'notifier_html',
    [
        'nickname' => $message->getSender()->getNickname(),
        'link' => $link,
    ]);
