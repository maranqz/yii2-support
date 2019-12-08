<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SSupport\Module\Core\Entity\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'customer_id')->textInput(); ?>

    <?= $form->field($model, 'assign_id')->textInput(); ?>

    <?= $form->field($model, 'created_at')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('ssupport', 'Save'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
