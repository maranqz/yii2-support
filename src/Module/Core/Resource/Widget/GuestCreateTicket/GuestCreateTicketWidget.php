<?php

namespace SSupport\Module\Core\Resource\Widget\GuestCreateTicket;

use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class GuestCreateTicketWidget extends Widget
{
    use ContainerAwareTrait;

    /** @var CreateTicketForm */
    public $model;
    /** @var ActiveForm */
    public $form;
    public $renderPath = '@SSupport/Module/Core/Resource/Widget/GuestCreateTicket/view/index';

    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return '';
        }

        return $this->render(
            $this->renderPath,
            [
                'model' => $this->model,
                'form' => $this->form,
            ]
        );
    }
}
