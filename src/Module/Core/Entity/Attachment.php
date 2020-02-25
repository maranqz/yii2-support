<?php

namespace SSupport\Module\Core\Entity;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\db\ActiveRecord;

class Attachment extends ActiveRecord implements AttachmentInterface
{
    use ContainerAwareTrait;
    use IdentifyTrait;

    public static function tableName()
    {
        return '{{%attachment}}';
    }

    public function rules()
    {
        return [
            [['message_id', 'path', 'size', 'name'], 'required'],
            [['message_id', 'size'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['path'], 'string', 'max' => 1024],
            [
                ['message_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => $this->getDIClass(MessageInterface::class),
                'targetAttribute' => ['message_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ssupport_core', 'ID'),
            'message_id' => Yii::t('ssupport_core', 'Message ID'),
            'path' => Yii::t('ssupport_core', 'Path'),
            'name' => Yii::t('ssupport_core', 'Name'),
            'size' => Yii::t('ssupport_core', 'Size'),
        ];
    }

    public function getPath(): string
    {
        return $this->__get('path');
    }

    public function getName(): string
    {
        return $this->__get('name');
    }

    public function getSize()
    {
        return $this->__get('size');
    }

    protected function getMessageQuery()
    {
        return $this->hasOne($this->getDIClass(MessageInterface::class), ['id' => 'message_id']);
    }
}
