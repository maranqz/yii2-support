<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInterface;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerCustomerRule;
use SSupport\Module\Core\Resource\config\GridView\CustomerGridViewSettingsInterface;
use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use SSupport\Module\Core\UseCase\Customer\TicketSearch;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
{
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use GetTicketByIdTrait;

    const PATH = 'customer/ticket/index';

    protected $highlighter;

    public function __construct($id, $module, HighlighterInterface $highlighter, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->highlighter = $highlighter;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create'],
                        'roles' => [Module::CUSTOMER_ROLE],
                    ],
                    [
                        'allow' => true,
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

    public function actionIndex()
    {
        /** @var TicketSearch $searchModel */
        $searchModel = $this->make(TicketSearch::class);
        $dataProvider = $searchModel->search(Yii::$app->getUser()->getId(), Yii::$app->request->queryParams);

        $gridViewSettings = $this->make(
            CustomerGridViewSettingsInterface::class,
            [$dataProvider, $searchModel, $this->getSupportCoreModule()->urlCreateGrid]
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridViewConfig' => ($this->getSupportCoreModule()->customerGridViewConfig)($gridViewSettings),
        ]);
    }

    public function actionView($ticketId)
    {
        $ticket = $this->findModel($ticketId);

        $this->highlighter->removeHighlight($ticket, Yii::$app->user->getIdentity());

        $messagesProvider = new ActiveDataProvider([
            'query' => $ticket->getRelatedMessages(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('view', [
            'ticket' => $ticket,
            'messagesProvider' => $messagesProvider,
            'detailView' => $this->getSupportCoreModule()->getViewDetailConfig($ticket),
        ]);
    }

    public function actionCreate()
    {
        /** @var CreateTicketForm $model */
        $model = $this->make(CreateTicketForm::class);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setCustomer(Yii::$app->getUser()->getIdentity());

            /** @var TicketInterface $ticket */
            $ticket = Yii::$app->db->transaction(function () use ($model) {
                return $this->make(CreateTicketInterface::class)($model);
            });

            return $this->redirect(['view', 'ticketId' => $ticket->getId()]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        /** @var TicketInterface|Ticket $model */
        if (null !== ($model = $this->make(TicketInterface::class)::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
