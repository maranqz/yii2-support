<?php

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessage;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\Resource\Widget\Messages\MessagesWidget;
use SSupport\Module\Referee\Controller\referee\ticket\MessageController;
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

    <?php $this->beginBlock('title', $this->context->inPlace('title')); ?>
    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php $this->endBlock(); ?>

    <div class="col-sm-8">
        <?php echo MessageFormWidget::widget([
            'ticket' => $ticket,
            'pjaxOptions' => [
                'enablePushState' => false,
            ],
            'action' => MessageController::PATH.'/send',
        ]); ?>

        <?php echo MessagesWidget::widget([
            'dataProvider' => $messagesProvider,
        ]); ?>
    </div>

    <div class="col-sm-4">
        <?php echo DetailView::widget($detailView); ?>
    </div>
</div>
