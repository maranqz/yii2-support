<?php

namespace SSupport\Module\Core\UseCase\Customer;

use SSupport\Component\Core\Entity\CustomerInterface;
use SSupport\Component\Core\Entity\MessageInterface;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\Gateway\Uploader\AttachmentUploadsAwareInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;
use SSupport\Module\Core\UseCase\Customer\Repository\GetCustomerByCreteTicketInputInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsAwareTrait;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadSettingsInterface;
use SSupport\Module\Core\UseCase\Form\AttachmentUploadsTrait;
use SSupport\Module\Core\UseCase\Form\FileAcceptAwareInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use SSupport\Module\Core\Utils\ModelGetParamsTrait;
use Yii;
use yii\base\Model;

class CreateTicketForm extends Model implements CreateTicketInputInterface, AttachmentUploadsAwareInterface, FileAcceptAwareInterface
{
    use AttachmentUploadSettingsAwareTrait;
    use AttachmentUploadsTrait;
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use ModelGetParamsTrait;

    public $nick_name;
    public $subject;
    public $text;

    public $isGuestHandle;
    protected $customer;

    protected $getCustomerByCreteTicketInput;

    public function __construct(
        AttachmentUploadSettingsInterface $attachmentUploadSettings,
        GetCustomerByCreteTicketInputInterface $getCustomerByCreteTicketInput,
        $guestUser = null,
        $config = []
    ) {
        parent::__construct($config);

        $this->attachmentUploadSettings = $attachmentUploadSettings;
        $this->getCustomerByCreteTicketInput = $getCustomerByCreteTicketInput;
        $this->isGuestHandle = $guestUser ?? $this->getSupportCoreModule()->isGuestCreateTicket;
    }

    public function rules()
    {
        $rules = [];
        if ($this->isGuestHandle && Yii::$app->user->isGuest) {
            $rules = [
                'nick_nameRequired' => [['nick_name'], 'required'],
                'nick_nameExist' => [
                    ['nick_name'],
                    'exist',
                    'targetClass' => $this->getDIClass(CustomerInterface::class),
                ],
            ];
        }

        $rules = array_merge(
            $this->getModelRulesByFields(TicketInterface::class, ['subject']),
            $this->getModelRulesByFields(MessageInterface::class, ['text']),
            $this->attachmentUploadSettings->getRules(),
            $rules
        );

        return $rules;
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->getModelAttributesByFields(TicketInterface::class, ['subject']),
            $this->getModelAttributesByFields(MessageInterface::class, ['text']),
            [
                'nick_name' => Yii::t('ssupport_core', 'Nickname'),
            ]
        );
    }

    public function getCustomer(): CustomerInterface
    {
        return ($this->getCustomerByCreteTicketInput)($this);
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
