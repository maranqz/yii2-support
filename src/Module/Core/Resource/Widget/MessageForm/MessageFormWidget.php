<?php

namespace SSupport\Module\Core\Resource\Widget\MessageForm;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\Controller\customer\ticket\MessageController;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use yii\base\Widget;

class MessageFormWidget extends Widget
{
    use ContainerAwareTrait;

    public $model;
    /** @var TicketInterface */
    public $ticket;
    public $action = MessageController::PATH.'/send';
    public $containerClass;
    public $formOptions = [
        'options' => [
            'data-pjax' => true,
        ],
    ];
    public $pjaxOptions = [];

    public function init()
    {
        parent::init();

        $this->model = $this->model ?? $this->make(SendMessageInputInterface::class);
    }

    public function run()
    {
        return $this->render(
            '@SSupport/Module/Core/Resource/Widget/MessageForm/view/index',
            [
                'model' => $this->model,
                'action' => [$this->action, 'ticket_id' => $this->ticket->getId()],
                'containerClass' => $this->containerClass,
                'formOptions' => $this->formOptions,
                'pjaxOptions' => $this->pjaxOptions,
            ]
        );
    }
}
