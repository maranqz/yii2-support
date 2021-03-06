<?php

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Resource\Assets\CommonAsset\CommonAsset;
use SSupport\Module\Core\Resource\Widget\Messages\Widget\AttachmentsWidget;
use SSupport\Module\Core\Resource\Widget\Messages\Widget\HeaderWidget;
use SSupport\Module\Core\Resource\Widget\Messages\Widget\TextWidget;

/* @var $model MessageInterface */
/* @var $currentUser UserInterface */

CommonAsset::register($this);

$attachments = $model->getAttachments();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo HeaderWidget::widget(['message' => $model]); ?>
    </div>
    <div class="panel-body">
        <?php echo TextWidget::widget(['message' => $model]); ?>
    </div>
    <?php if ($attachments) { ?>
        <div class="panel-footer">
            <?php echo AttachmentsWidget::widget([
                'attachments' => $attachments,
            ]); ?>
        </div>
    <?php } ?>
</div>
