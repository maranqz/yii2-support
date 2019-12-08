<?php

namespace SSupport\Module\Core\Entity;

use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Entity\Utils\CreatedAtTrait;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
use SSupport\Module\Core\Gateway\Repository\MessageRepository;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

class Message extends ActiveRecord implements MessageInterface
{
    use ContainerAwareTrait;
    use IdentifyTrait;
    use CreatedAtTrait;

    public static function tableName()
    {
        return '{{%message}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['ticket_id', 'sender_id', 'text', 'created_at'], 'required'],
            [['ticket_id', 'sender_id'], 'integer'],
            [['text'], 'string'],
            [
                ['sender_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => $this->getClass(UserInterface::class),
                'targetAttribute' => ['sender_id' => 'id'],
            ],
            [
                ['ticket_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => $this->getClass(TicketInterface::class),
                'targetAttribute' => ['ticket_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii2-support', 'ID'),
            'ticket_id' => Yii::t('yii2-support', 'Ticket ID'),
            'sender_id' => Yii::t('yii2-support', 'Sender ID'),
            'text' => Yii::t('yii2-support', 'Text'),
            'created_at' => Yii::t('yii2-support', 'Created At'),
        ];
    }

    public function getText(): string
    {
        return $this->__get('text');
    }

    public function setText(string $text): MessageInterface
    {
        $this->__set('text', $text);

        return $this;
    }

    public function getAttachments(): iterable
    {
        return $this->__get('attachmentsQuery');
    }

    protected function getAttachmentsQuery()
    {
        return $this->hasMany($this->getClass(AttachmentInterface::class), ['message_id' => 'id']);
    }

    /** @param AttachmentInterface|ActiveRecordInterface $attachment */
    public function addAttachment(AttachmentInterface $attachment): MessageInterface
    {
        $this->link('attachmentsQuery', $attachment);

        return $this;
    }

    public function getSender(): UserInterface
    {
        return $this->__get('senderQuery');
    }

    protected function getSenderQuery()
    {
        return $this->hasOne($this->getClass(UserInterface::class), ['id' => 'sender_id']);
    }

    public function getTicket(): TicketInterface
    {
        return $this->__get('ticketQuery');
    }

    protected function getTicketQuery()
    {
        return $this->hasOne($this->getClass(TicketInterface::class), ['id' => 'ticket_id']);
    }

    public static function find()
    {
        return new MessageRepository(\get_called_class());
    }
}
