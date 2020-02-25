<?php

use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CreateTicketForm */

$this->title = Yii::t('ssupport_core', 'Create Ticket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport_core', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <h1><?= Html::encode($this->title); ?></h1>

    <div class="ticket-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'text')->textarea(); ?>

        <?= $form->field($model, 'files[]')->fileInput([
            'multiple' => true,
            'accept' => $model->getAcceptType(),
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('ssupport_core', 'Save'), ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
