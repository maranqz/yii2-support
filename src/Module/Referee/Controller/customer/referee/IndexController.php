<?php

namespace SSupport\Module\Referee\Controller\customer\referee;

use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInputInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInterface;
use SSupport\Module\Core\Controller\customer\ticket\IndexController as TicketController;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerCustomerRule;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use SSupport\Module\Referee\UseCase\Customer\RequestRefereeInputForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class IndexController extends Controller
{
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use GetTicketByIdTrait;

    const PATH = 'customer/referee/index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request'],
                        'permissions' => [IsOwnerCustomerRule::NAME],
                        'roleParams' => function () {
                            return [
                                'ticket' => $this->getTicketById(Yii::$app->request->get('ticketId')),
                            ];
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionRequest($ticketId)
    {
        /** @var RequestRefereeInputInterface|RequestRefereeInputForm $requestRefereeForm */
        $requestRefereeForm = $this->make(RequestRefereeInputInterface::class);

        $requestRefereeForm->setRequester(Yii::$app->getUser()->getIdentity())
            ->setTicket($this->getTicketById($ticketId));

        if ($requestRefereeForm->validate()) {
            Yii::$app->db->transaction(function () use ($requestRefereeForm) {
                $this->make(RequestRefereeInterface::class)($requestRefereeForm);
            });
        } else {
            throw new \UnexpectedValueException($requestRefereeForm->errors);
        }

        return $this->redirect([
            $this->getSupportCoreModule()->getRoute(TicketController::PATH.'/view'),
            Module::TICKET_ID => $ticketId,
        ]);
    }
}
