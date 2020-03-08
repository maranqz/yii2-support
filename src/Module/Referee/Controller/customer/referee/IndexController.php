<?php

namespace SSupport\Module\Referee\Controller\customer\referee;

use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInputInterface;
use SSupport\Component\Referee\UseCase\Customer\RequestReferee\RequestRefereeInterface;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequestInputInterface;
use SSupport\Component\Referee\UseCase\Customer\SetTimeoutRequest\SetTimeoutRequestInterface;
use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Controller\customer\ticket\IndexController as TicketController;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerCustomerRule;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use SSupport\Module\Referee\Gateway\TimeoutRequestRefereeStatus\TimeoutRequestRefereeStatusInterface;
use SSupport\Module\Referee\UseCase\Customer\RequestRefereeInputForm;
use SSupport\Module\Referee\UseCase\Customer\SetTimeoutRequestInputForm;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class IndexController extends Controller
{
    use BlockTrait;
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use GetTicketByIdTrait;
    use RefereeModuleAwareTrait;

    const PATH = 'customer/referee/index';

    protected $timeoutRequestRefereeStatus;

    public function __construct(
        $id,
        $module,
        TimeoutRequestRefereeStatusInterface $timeoutRequestRefereeStatus,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->timeoutRequestRefereeStatus = $timeoutRequestRefereeStatus;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request', 'timeout-request'],
                        'permissions' => [IsOwnerCustomerRule::NAME],
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

    public function actionRequest($ticketId)
    {
        $ticket = $this->getTicketByIdOrNull($ticketId);

        if ($this->timeoutRequestRefereeStatus->canSetTimeoutRequestReferee($ticket)) {
            return $this->actionTimeoutRequest($ticketId);
        }

        /** @var RequestRefereeInputInterface|RequestRefereeInputForm $requestRefereeForm */
        $requestRefereeForm = $this->make(RequestRefereeInputInterface::class);

        $requestRefereeForm->setRequester(Yii::$app->getUser()->getIdentity())
            ->setTicket($ticket);

        if ($requestRefereeForm->validate()) {
            Yii::$app->db->transaction(function () use ($requestRefereeForm) {
                $this->make(RequestRefereeInterface::class)($requestRefereeForm);
            });
        } else {
            throw new \UnexpectedValueException($requestRefereeForm->errors);
        }

        return $this->redirect([
            $this->getSupportCoreModule()->getRoute(TicketController::PATH . '/view'),
            Module::TICKET_ID => $ticketId,
        ]);
    }

    public function actionTimeoutRequest($ticketId)
    {
        $ticket = $this->getTicketByIdOrNull($ticketId);
        if ($this->timeoutRequestRefereeStatus->canRequestReferee($ticket)) {
            return $this->actionRequest($ticketId);
        }

        $timeoutRequestReferee = $this->getSupportRefereeModule()->timeoutRequestReferee;

        /** @var SetTimeoutRequestInputInterface|SetTimeoutRequestInputForm $setTimeoutRequestForm */
        $setTimeoutRequestForm = $this->make(SetTimeoutRequestInputInterface::class);

        $setTimeoutRequestForm->setRequester(Yii::$app->getUser()->getIdentity())
            ->setTimeoutRequest($ticket)
            ->setTimeout($timeoutRequestReferee);

        if ($setTimeoutRequestForm->validate()) {
            Yii::$app->db->transaction(function () use ($setTimeoutRequestForm) {
                $this->make(SetTimeoutRequestInterface::class)($setTimeoutRequestForm);
            });
        } else {
            throw new \UnexpectedValueException($setTimeoutRequestForm->errors);
        }

        return $this->redirect([
            $this->getSupportCoreModule()->getRoute(TicketController::PATH . '/view'),
            Module::TICKET_ID => $ticketId,
        ]);
    }
}
