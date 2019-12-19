<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SSupport\Module\Core\Entity\TicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'id'); ?>

    <?= $form->field($model, 'subject'); ?>

    <?= $form->field($model, 'customer_id'); ?>

    <?= $form->field($model, 'assign_id'); ?>

    <?= $form->field($model, 'created_at'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ssupport', 'Search'), ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton(Yii::t('ssupport', 'Reset'), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
