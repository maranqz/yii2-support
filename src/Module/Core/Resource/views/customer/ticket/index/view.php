<?php

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\Resource\Widget\Messages\MessagesWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $ticket SSupport\Module\Core\Entity\Ticket */
/* @var $sendMessage SendMessage */
/* @var $messagesProvider ActiveDataProvider */

$this->title = $ticket->getSubject();
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= DetailView::widget([
        'model' => $ticket,
        'attributes' => [
            [
                'label' => Yii::t('ssupport', 'Nickname'),
                'value' => $ticket->getCustomer()->getNickname(),
            ],
            [
                'label' => Yii::t('ssupport', 'Assign'),
                'value' => $ticket->getAssigns()[0]->getNickname(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <?= MessageFormWidget::widget([
        'ticket' => $ticket,
        'pjaxOptions' => [
            'enablePushState' => false,
        ],
    ]); ?>

    <?= MessagesWidget::widget([
        'dataProvider' => $messagesProvider,
    ]); ?>
</div>
