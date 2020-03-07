<?php

use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var CreateTicketForm $model
 * @var ActiveForm $form
 */
?>
<?php echo $form->field($model, 'nick_name')->textInput(['maxlength' => true]); ?>
