<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\UseCase\Customer\SendMessageInputForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MessageController extends Controller
{
    use ContainerAwareTrait;

    const PATH = 'customer/ticket/message';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSend($ticket_id)
    {
        /** @var SendMessageInputForm $model */
        $model = $this->make(SendMessageInputInterface::class);

        $ticket = $this->findModel($ticket_id);
        $model->setTicket($ticket);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setCustomer(Yii::$app->getUser()->getIdentity());

            $this->make(SendMessageInterface::class)($model);
            $ticket->save();

            return $this->redirect([IndexController::PATH.'/view', 'id' => $ticket->getId()]);
        }

        return $this->renderContent(MessageFormWidget::widget([
            'model' => $model,
            'ticket' => $ticket,
        ]));
    }

    protected function findModel($id)
    {
        if (null !== ($model = Ticket::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('ssupport', 'The requested page does not exist.'));
    }
}
