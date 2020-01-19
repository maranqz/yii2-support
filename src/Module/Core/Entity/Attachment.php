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
            'id' => Yii::t('yii2-support', 'ID'),
            'message_id' => Yii::t('yii2-support', 'Message ID'),
            'path' => Yii::t('yii2-support', 'Path'),
            'name' => Yii::t('yii2-support', 'Name'),
            'size' => Yii::t('yii2-support', 'Size'),
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
