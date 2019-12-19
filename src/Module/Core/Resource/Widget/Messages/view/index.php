<?php

use SSupport\Component\Core\Entity\UserInterface;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $currentUser UserInterface */

?>

<?php Pjax::begin(); ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@SSupport/Module/Core/Resource/Widget/Messages/view/message',
    'viewParams' => [
        'currentUser' => $currentUser,
    ],
]); ?>

<?php Pjax::end(); ?>
