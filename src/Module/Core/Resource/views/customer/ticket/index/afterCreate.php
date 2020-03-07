<?php

use SSupport\Module\Core\Controller\customer\ticket\IndexController;
use SSupport\Module\Core\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticketId */

$this->title = Yii::t('ssupport_core', 'ticket_created_success');
$this->params['breadcrumbs'][] = ['label' => Yii::t('ssupport_core', 'Create ticket'), 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-guest-after-create">
    <?php echo Yii::t('ssupport_core', 'ticket_created_success'); ?>

    <?php echo Yii::t('ssupport_core', 'to_view_ticket', [
        'link' => Html::a(
            Yii::t('ssupport_core', 'authorize'),
            [IndexController::PATH . '/view', Module::TICKET_ID => $ticketId]
        ),
    ]); ?>
</div>
