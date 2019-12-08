<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SSupport\Module\Core\Entity\Ticket */

$this->title = Yii::t('ssupport', 'Create Ticket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <h1><?= Html::encode($this->title); ?></h1>

    <div class="ticket-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'text')->textarea(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('ssupport', 'Save'), ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
