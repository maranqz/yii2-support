<?php

namespace SSupport\Module\Core\Entity;

use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Entity\Utils\CustomerAwareInterface;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
use SSupport\Module\Core\Entity\Utils\TimestampTrait;
use SSupport\Module\Core\Exception\NotImplementedException;
use SSupport\Module\Core\Gateway\Repository\TicketRepository;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecordInterface;
use yii\db\ActiveRecord;

class Ticket extends ActiveRecord implements TicketInterface
{
    use IdentifyTrait;
    use TimestampTrait;

    public static function tableName()
    {
        return '{{%ticket}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['subject', 'assign_id', 'created_at', 'updated_at'], 'required'],
            [['customer_id', 'assign_id', 'created_at'], 'integer'],
            [['subject'], 'string', 'max' => 1024],
            [
                ['assign_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['assign_id' => 'id'],
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['customer_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii2-support', 'ID'),
            'subject' => Yii::t('yii2-support', 'Subject'),
            'customer_id' => Yii::t('yii2-support', 'Customer ID'),
            'assign_id' => Yii::t('yii2-support', 'Assign ID'),
            'created_at' => Yii::t('yii2-support', 'Created At'),
            'updated_at' => Yii::t('yii2-support', 'Updated At'),
        ];
    }

    public function getSubject(): string
    {
        return $this->__get('subject');
    }

    public function setSubject(string $subject): TicketInterface
    {
        $this->__set('subject', $subject);

        return $this;
    }

    public function getMessages(): iterable
    {
        return $this->__get('messagesQuery');
    }

    protected function getMessagesQuery()
    {
        return $this->hasMany(Message::className(), ['ticket_id' => 'id']);
    }

    /** @param MessageInterface|Message $message */
    public function addMessage(MessageInterface $message): TicketInterface
    {
        $message->link('ticket', $this);

        return $this;
    }

    public function getAssigns(): iterable
    {
        return [$this->__get('assignQuery')];
    }

    protected function getAssignQuery()
    {
        return $this->hasOne(User::className(), ['id' => 'assign_id']);
    }

    /** @param UserInterface|ActiveRecordInterface $user */
    public function assign(UserInterface $user): TicketInterface
    {
        $this->link('assignQuery', $user);

        return $this;
    }

    public function deassign(UserInterface $user): TicketInterface
    {
        throw new NotImplementedException();
    }

    public function getCustomer(): ?UserInterface
    {
        return $this->__get('customerQuery');
    }

    /** @param UserInterface|ActiveRecordInterface $customer */
    public function setCustomer(?UserInterface $customer): CustomerAwareInterface
    {
        $this->link('customerQuery', $customer);

        return $this;
    }

    protected function getCustomerQuery()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    public static function find()
    {
        return new TicketRepository(\get_called_class());
    }
}
