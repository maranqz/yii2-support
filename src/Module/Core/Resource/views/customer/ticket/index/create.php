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

    <?php $this->beginBlock('title', empty($this->context->blocks['title'])); ?>
    <h1><?php echo Html::encode($this->title); ?></h1>
    <?php $this->endBlock(); ?>

    <div class="ticket-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php echo $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

        <?php echo $form->field($model, 'text')->textarea(); ?>

        <?php echo $form->field($model, 'files[]')->fileInput([
            'multiple' => true,
            'accept' => $model->getAcceptType(),
        ]); ?>

        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('ssupport_core', 'Save'), ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
