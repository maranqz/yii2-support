<?php

namespace SSupport\Module\Core\Controller\agent\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\UseCase\Customer\SendMessageInputForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MessageController extends Controller
{
    use ContainerAwareTrait;

    const PATH = 'agent/ticket/message';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Module::AGENT_ROLE],
                    ],
                ],
            ],
        ];
    }

    public function actionSend($ticketId)
    {
        /** @var SendMessageInputForm $model */
        $model = $this->make(SendMessageInputInterface::class);

        $ticket = $this->findModel($ticketId);
        $model->setTicket($ticket);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->db->transaction(function () use ($model) {
                $model->setCustomer(Yii::$app->getUser()->getIdentity());

                $this->make(SendMessageInterface::class)($model);
            });

            return $this->redirect([
                IndexController::PATH.'/view',
                Module::TICKET_ID => $ticket->getId(),
            ]);
        }

        return $this->renderContent(MessageFormWidget::widget([
            'model' => $model,
            'ticket' => $ticket,
        ]));
    }

    protected function findModel($id)
    {
        if (null !== ($model = $this->make(TicketInterface::class)::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
