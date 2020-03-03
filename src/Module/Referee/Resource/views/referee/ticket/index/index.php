<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel SSupport\Module\Referee\UseCase\Referee\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $gridViewConfig array */

$this->title = Yii::t('ssupport_core', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <?php $this->beginBlock('title', $this->context->inPlace('title')); ?>
    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php $this->endBlock(); ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?php echo GridView::widget($gridViewConfig); ?>
    <?php Pjax::end(); ?>
</div>
