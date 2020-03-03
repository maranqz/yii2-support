<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SSupport\Module\Core\UseCase\Customer\TicketSearch */
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

    <?php echo $form->field($model, 'id'); ?>

    <?php echo $form->field($model, 'subject'); ?>

    <?php echo $form->field($model, 'customer_id'); ?>

    <?php echo $form->field($model, 'assign_id'); ?>

    <?php echo $form->field($model, 'created_at'); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('ssupport_core', 'Search'), ['class' => 'btn btn-primary']); ?>
        <?php echo Html::resetButton(Yii::t('ssupport_core', 'Reset'), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
