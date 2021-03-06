<?php

use SSupport\Module\Core\UseCase\Form\AbstractSendMessageInputForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var AbstractSendMessageInputForm $model
 * @var string $action
 * @var string $containerClass
 * @var array $formOptions
 * @var array $pjaxOptions
 */
?>
<div class="message-form <?php echo $containerClass; ?>">

    <?php Pjax::begin($pjaxOptions); ?>
    <?php $form = ActiveForm::begin(array_replace_recursive([
        'action' => $action,
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ], $formOptions)); ?>

    <?php echo $form->field($model, 'text')->textarea(); ?>

    <?php echo $form->field($model, 'files[]')->fileInput([
        'multiple' => true,
        'accept' => $model->getAcceptType(),
    ]); ?>


    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('ssupport_core', 'Send'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
