<?php

namespace SSupport\Module\Core\Entity;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
use SSupport\Module\Core\Gateway\Repository\AttachmentRepository;
use Yii;
use yii\db\ActiveRecord;

class Attachment extends ActiveRecord implements AttachmentInterface
{
    use IdentifyTrait;

    public static function tableName()
    {
        return '{{%attachment}}';
    }

    public function rules()
    {
        return [
            [['message_id', 'path', 'size', 'driver'], 'required'],
            [['message_id', 'size'], 'integer'],
            [['path'], 'string'],
            [
                ['message_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Message::className(),
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
            'size' => Yii::t('yii2-support', 'Size'),
        ];
    }

    public function getPath(): string
    {
        return $this->__get('path');
    }

    public function getName(): string
    {
        return basename($this->getPath());
    }

    public function getSize()
    {
        return $this->__get('size');
    }

    protected function getMessageQuery()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    public static function find()
    {
        return new AttachmentRepository(\get_called_class());
    }
}
