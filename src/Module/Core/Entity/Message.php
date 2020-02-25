<?php

namespace SSupport\Module\Core\Entity;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use SSupport\Component\Core\Entity\AttachmentInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Module\Core\Entity\Utils\CreatedAtTrait;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
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
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'attachmentsQuery',
                ],
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
                'targetClass' => $this->getDIClass(UserInterface::class),
                'targetAttribute' => ['sender_id' => 'id'],
            ],
            [
                ['ticket_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => $this->getDIClass(TicketInterface::class),
                'targetAttribute' => ['ticket_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ssupport_core', 'ID'),
            'ticket_id' => Yii::t('ssupport_core', 'Ticket ID'),
            'sender_id' => Yii::t('ssupport_core', 'Sender ID'),
            'text' => Yii::t('ssupport_core', 'Text'),
            'created_at' => Yii::t('ssupport_core', 'Created At'),
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
        return $this->hasMany($this->getDIClass(AttachmentInterface::class), ['message_id' => 'id']);
    }

    /** @param AttachmentInterface[] $attachments */
    public function addAttachments(iterable $attachments): MessageInterface
    {
        foreach ($attachments as $attachment) {
            $this->addAttachment($attachment);
        }

        return $this;
    }

    /** @param AttachmentInterface|ActiveRecordInterface $attachment */
    public function addAttachment(AttachmentInterface $attachment): MessageInterface
    {
        $attachments = $this->getAttachments();
        $attachments[] = $attachment;

        $this->__set('attachmentsQuery', $attachments);

        return $this;
    }

    public function setSender(UserInterface $sender): self
    {
        $this->__set('sender_id', $sender->getId());

        return $this;
    }

    public function getSender(): UserInterface
    {
        return $this->__get('senderQuery');
    }

    protected function getSenderQuery()
    {
        return $this->hasOne($this->getDIClass(UserInterface::class), ['id' => 'sender_id']);
    }

    public function getTicket(): TicketInterface
    {
        return $this->__get('ticketQuery');
    }

    protected function getTicketQuery()
    {
        return $this->hasOne($this->getDIClass(TicketInterface::class), ['id' => 'ticket_id']);
    }
}
