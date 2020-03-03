<?php

namespace SSupport\Module\Referee\Controller\referee\ticket;

use SSupport\Component\Referee\Entity\RefereeTicketInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInputInterface;
use SSupport\Component\Referee\UseCase\Referee\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Module as CoreModule;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Referee\Module as RefereeModule;
use SSupport\Module\Referee\UseCase\Referee\SendMessageInputForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MessageController extends Controller
{
    use BlockTrait;
    use ContainerAwareTrait;

    const PATH = 'referee/ticket/message';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        /*
                         * @TODO setting block only set ticket
                         */
                        'allow' => true,
                        'roles' => [RefereeModule::REFEREE_ROLE],
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
                $model->setReferee(Yii::$app->getUser()->getIdentity());

                $this->make(SendMessageInterface::class)($model);
            });

            return $this->redirect([
                IndexController::PATH.'/view',
                CoreModule::TICKET_ID => $ticket->getId(),
            ]);
        }

        return $this->renderContent(MessageFormWidget::widget([
            'model' => $model,
            'ticket' => $ticket,
        ]));
    }

    protected function findModel($id)
    {
        if (null !== ($model = $this->make(RefereeTicketInterface::class)::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
