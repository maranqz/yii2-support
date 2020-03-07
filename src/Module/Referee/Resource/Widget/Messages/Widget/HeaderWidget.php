<?php

namespace SSupport\Module\Referee\Resource\Widget\Messages\Widget;

use SSupport\Module\Core\Entity\Message;
use SSupport\Module\Referee\Module;
use Yii;
use yii\base\Widget;

class HeaderWidget extends Widget
{
    /** @var Message */
    public $message;
    /** @var callable someFunction(HeaderWidget) */
    public $refereeMark;
    /** @var string */
    public $template = '%s%s (%s)';

    public function init()
    {
        parent::init();

        if (empty($this->refereeMark)) {
            $this->refereeMark = [$this, 'getRefereeMarkDefault'];
        }
    }

    public function run()
    {
        return sprintf(
            $this->template,
            $this->message->getSender()->getNickname(),
            ($this->refereeMark)($this),
            Yii::$app->formatter->asDatetime($this->message->getCreatedAt())
        );
    }

    protected function getRefereeMarkDefault()
    {
        if (Yii::$app->authManager->checkAccess(
            $this->message->getSender()->getId(),
            Module::REFEREE_ROLE
        )) {
            return ' / ' . Yii::t('ssupport_referee', 'Referee');
        }

        return '';
    }
}
