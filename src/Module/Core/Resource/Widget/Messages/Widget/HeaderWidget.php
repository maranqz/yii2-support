<?php

namespace SSupport\Module\Core\Resource\Widget\Messages\Widget;

use SSupport\Module\Core\Entity\Message;
use Yii;
use yii\base\Widget;

class HeaderWidget extends Widget
{
    /** @var Message */
    public $message;
    /** @var string */
    public $template = '%s (%s)';

    public function run()
    {
        return sprintf(
            $this->template,
            $this->message->getSender()->getNickname(),
            Yii::$app->formatter->asDatetime($this->message->getCreatedAt())
        );
    }
}
