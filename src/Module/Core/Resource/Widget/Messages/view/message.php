<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Resource\Assets\CommonAsset\CommonAsset;
use SSupport\Module\Core\Resource\Widget\AttachmentPath\AttachmentPathWidget;
use yii\helpers\Html;

/* @var $model MessageInterface */
/* @var $currentUser UserInterface */

CommonAsset::register($this);

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
                        Yii::$app->formatter->asSize($attachment->getSize())
                    ),
                    AttachmentPathWidget::widget(['path' => $attachment->getPath()]),
                    [
                        'class' => 'text-break',
                        'target' => '_blank',
                    ]
                ); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
