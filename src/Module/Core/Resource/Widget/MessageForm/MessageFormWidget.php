<?php

namespace SSupport\Module\Core\Resource\Widget\MessageForm;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use yii\base\Widget;

class MessageFormWidget extends Widget
{
    use ContainerAwareTrait;

    public $model;
    /** @var TicketInterface */
    public $ticket;
    public $action;
    public $containerClass;
    public $formOptions = [
        'options' => [
            'data-pjax' => true,
        ],
    ];
    public $pjaxOptions = [];
    /** @var callable */
    public $getAction;
    public $renderPath = '@SSupport/Module/Core/Resource/Widget/MessageForm/view/index';

    public function init()
    {
        parent::init();

        if (empty($this->action)) {
            throw new \InvalidArgumentException('$action must be set');
        }

        $this->model = $this->model ?? $this->make(SendMessageInputInterface::class);

        if (empty($this->getAction)) {
            $this->getAction = [$this, 'getActionDefault'];
        }
    }

    public function run()
    {
        return $this->render(
            $this->renderPath,
            [
                'model' => $this->model,
                'action' => ($this->getAction)($this),
                'containerClass' => $this->containerClass,
                'formOptions' => $this->formOptions,
                'pjaxOptions' => $this->pjaxOptions,
            ]
        );
    }

    protected function getActionDefault()
    {
        return [$this->action, 'ticketId' => $this->ticket->getId()];
    }
}
