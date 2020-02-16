<?php

namespace SSupport\Module\Core\Resource\Widget\Messages\Widget;

use SSupport\Module\Core\Entity\Message;
use yii\base\Widget;
use yii\helpers\Html;

class TextWidget extends Widget
{
    /** @var Message */
    public $message;

    public function run()
    {
        return Html::encode($this->message->getText());
    }
}
