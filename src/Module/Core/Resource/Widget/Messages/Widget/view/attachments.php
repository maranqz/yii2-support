<?php

use SSupport\Module\Core\Entity\Attachment;
use SSupport\Module\Core\Resource\Widget\AttachmentPath\AttachmentPathWidget;
use yii\helpers\Html;

/* @var $attachments Attachment[] */
?>

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