<?php

namespace SSupport\Module\Core\Entity;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use paulzi\jsonBehavior\JsonBehavior;
use paulzi\jsonBehavior\JsonValidator;
use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Entity\UserInterface;
use SSupport\Component\Core\Entity\Utils\CustomerAwareInterface;
use SSupport\Module\Core\Entity\Utils\IdentifyTrait;
use SSupport\Module\Core\Entity\Utils\TimestampTrait;
use SSupport\Module\Core\Exception\NotImplementedException;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;

/**
 * @property $readers JsonField
 */
class Ticket extends ActiveRecord implements TicketInterface
{
    use ContainerAwareTrait;
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
                'class' => TimestampBehavior::class,
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['relatedMessages', 'relatedAssign', 'relatedCustomer'],
            ],
            [
                'class' => JsonBehavior::class,
                'attributes' => ['readers'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['subject', 'assign_id'], 'required'],
            [['customer_id', 'assign_id', 'created_at'], 'integer'],
            [['subject'], 'string', 'min' => 5, 'max' => 1024],
            [
                ['assign_id'],
                'exist',
                'skipOnError' => true,
                'targetRelation' => 'relatedAssign',
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetRelation' => 'relatedCustomer',
            ],
            [['readers'], JsonValidator::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ssupport_core', 'ID'),
            'subject' => Yii::t('ssupport_core', 'Subject'),
            'customer_id' => Yii::t('ssupport_core', 'Customer ID'),
            'assign_id' => Yii::t('ssupport_core', 'Assign ID'),
            'created_at' => Yii::t('ssupport_core', 'Created At'),
            'updated_at' => Yii::t('ssupport_core', 'Updated At'),
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
        return $this->__get('relatedMessages');
    }

    public function getRelatedMessages()
    {
        return $this->hasMany($this->getDIClass(MessageInterface::class), ['ticket_id' => 'id']);
    }

    /** @param MessageInterface|Message $message */
    public function addMessage(MessageInterface $message): TicketInterface
    {
        $this->__set('updated_at', null);
        /* @TODO trick for create ticket before create image */
        $message->link('ticketQuery', $this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssigns(): iterable
    {
        return [$this->__get('relatedAssign')];
    }

    public function getRelatedAssign()
    {
        return $this->hasOne($this->getDIClass(UserInterface::class), ['id' => 'assign_id']);
    }

    /** @param UserInterface|ActiveRecordInterface $user */
    public function assign(UserInterface $user): TicketInterface
    {
        $this->link('relatedAssign', $user);

        return $this;
    }

    public function deassign(UserInterface $user): TicketInterface
    {
        throw new NotImplementedException();
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->__get('relatedCustomer');
    }

    /** @param CustomerInterface|ActiveRecordInterface $customer */
    public function setCustomer(CustomerInterface $customer): CustomerAwareInterface
    {
        $this->__set('relatedCustomer', $customer);

        return $this;
    }

    public function getRelatedCustomer()
    {
        return $this->hasOne($this->getDIClass(CustomerInterface::class), ['id' => 'customer_id']);
    }

    public function addReader(UserInterface $reader)
    {
        $this->readers[$reader->getId()] = 1;

        return $this;
    }

    public function isReader(UserInterface $reader)
    {
        return isset($this->readers[$reader->getId()]);
    }

    public function clearReaders()
    {
        $this->readers->set('{}');
    }
}
