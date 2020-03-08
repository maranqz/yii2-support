<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInputInterface;
use SSupport\Component\Core\UseCase\Customer\SendMessage\SendMessageInterface;
use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerCustomerRule;
use SSupport\Module\Core\Resource\Widget\MessageForm\MessageFormWidget;
use SSupport\Module\Core\UseCase\Customer\SendMessageInputForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class MessageController extends Controller
{
    use BlockTrait;
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use GetTicketByIdTrait;

    const PATH = 'customer/ticket/message';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'permissions' => [IsOwnerCustomerRule::NAME],
                        'verbs' => ['POST'],
                        'roleParams' => function () {
                            return [
                                'ticket' => $this->getTicketByIdOrNull(Yii::$app->request->get('ticketId')),
                            ];
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionSend($ticketId)
    {
        /** @var SendMessageInputForm $model */
        $model = $this->make(SendMessageInputInterface::class);

        $ticket = $this->getTicketById($ticketId);
        $model->setTicket($ticket);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->db->transaction(function () use ($model) {
                $model->setCustomer(Yii::$app->getUser()->getIdentity());

                $this->make(SendMessageInterface::class)($model);
            });

            return $this->redirect([
                IndexController::PATH . '/view',
                Module::TICKET_ID => $ticket->getId(),
            ]);
        }

        return $this->renderContent(MessageFormWidget::widget([
            'model' => $model,
            'ticket' => $ticket,
            'action' => self::PATH . '/send',
        ]));
    }
}
