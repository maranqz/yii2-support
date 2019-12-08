<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model SSupport\Module\Core\Entity\Ticket */

$this->title = Yii::t('ssupport', 'Create Ticket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
