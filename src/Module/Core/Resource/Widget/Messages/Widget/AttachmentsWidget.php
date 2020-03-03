<?php

namespace SSupport\Module\Core\Resource\Widget\Messages\Widget;

use SSupport\Module\Core\Entity\Attachment;
use yii\base\Widget;

class AttachmentsWidget extends Widget
{
    /** @var Attachment[] */
    public $attachments;
    public $renderPath = '@SSupport/Module/Core/Resource/Widget/Messages/Widget/view/attachments';

    public function run()
    {
        return $this->render($this->renderPath, [
            'attachments' => $this->attachments,
        ]);
    }
}
