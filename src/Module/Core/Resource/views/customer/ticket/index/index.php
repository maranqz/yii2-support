<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel SSupport\Module\Core\UseCase\Customer\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $gridViewConfig array */

$this->title = Yii::t('ssupport', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title); ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?= Html::a(Yii::t('ssupport', 'Create Ticket'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>


    <?= GridView::widget($gridViewConfig); ?>
    <?php Pjax::end(); ?>
</div>
