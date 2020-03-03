<?php

namespace SSupport\Module\Core\UseCase\Form;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\ModelGetParamsTrait;
use Yii;
use yii\base\Model;

abstract class AbstractSendMessageInputForm extends Model implements FileAcceptAwareInterface
{
    use ContainerAwareTrait;
    use ModelGetParamsTrait;

    public $text;

    public $filesMimeTypes = 'text/plain';

    protected $_files;

    public function rules()
    {
        return array_merge(
            $this->getModelRulesByFields(MessageInterface::class, ['ticket_id']),
            $this->getModelRulesByFields(MessageInterface::class, ['text']),
            [
                [['files'], 'file', 'maxFiles' => '5', 'mimeTypes' => $this->filesMimeTypes],
            ]
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->getModelAttributesByFields(MessageInterface::class, ['text']),
            [
                'files' => Yii::t('ssupport_core', 'Files'),
            ]
        );
    }

    public function getTicket_id()
    {
        return $this->getTicket()->getId();
    }

    public function getText(): string
    {
        return $this->text;
    }
}
