<?php

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage;
use SSupport\Module\Core\Controller\agent\ticket\MessageController;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\Resource\Widget\Messages\MessagesWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $ticket SSupport\Module\Core\Entity\Ticket */
/* @var $sendMessage SendMessage */
/* @var $messagesProvider ActiveDataProvider */
/* @var $detailView array */

$this->title = $ticket->getSubject();
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport_core', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title); ?></h1>

    <div class="col-sm-8">
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

    <div class="col-sm-4">
        <?= DetailView::widget($detailView); ?>
    </div>

</div>
