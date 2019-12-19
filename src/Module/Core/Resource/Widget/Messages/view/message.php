<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\UserInterface;
use yii\helpers\Html;

/* @var $model MessageInterface */
/* @var $currentUser UserInterface */

$attachments = $model->getAttachments();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= $model->getSender()->getNickname(); ?>
        (<?= Yii::$app->formatter->asDatetime($model->getCreatedAt()); ?>)
    </div>
    <div class="panel-body">
        <?= Html::encode($model->getText()); ?>
    </div>
    <?php if ($attachments): ?>
        <div class="panel-footer">
            <?php foreach ($attachments as $attachment): ?>
                <?= Html::a(
                    sprintf('%s (%s)',
                        $attachment->getName(),
                        Yii::$app->formatter->asShortSize($attachment->getSize())
                    ),
                        $attachment->getPath() // @TODO создать хелпер для получения пути в зависимости от адаптера файловой системы
                    ); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
