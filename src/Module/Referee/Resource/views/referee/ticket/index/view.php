<?php

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\Resource\Widget\Messages\MessagesWidget;
use SSupport\Module\Referee\Controller\referee\ticket\MessageController;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $ticket SSupport\Module\Core\Entity\Ticket */
/* @var $sendMessage SendMessage */
/* @var $messagesProvider ActiveDataProvider */
/* @var $detailView array */

$this->title = $ticket->getSubject();
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= DetailView::widget($detailView); ?>

    <?= MessageFormWidget::widget([
        'ticket' => $ticket,
        'pjaxOptions' => [
            'enablePushState' => false,
        ],
        'action' => MessageController::PATH.'/send',
    ]); ?>

    <?= MessagesWidget::widget([
        'dataProvider' => $messagesProvider,
    ]); ?>
</div>