<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInputInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInterface;
use SSupport\Module\Core\Controller\BlockTrait;
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

class IndexController extends Controller
{
    use BlockTrait;
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
    use GetTicketByIdTrait;

    const PATH = 'customer/ticket/index';

    protected $highlighter;
    protected $redirectAfterCreateTicket;

    public function __construct(
        $id,
        $module,
        HighlighterInterface $highlighter,
        RedirectAfterCreateTicketInterface $redirectAfterCreateTicket,
        $config = []
    ) {
        parent::__construct($id, $module, $config);

        $this->highlighter = $highlighter;
        $this->redirectAfterCreateTicket = $redirectAfterCreateTicket;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'after-create'],
                        'roles' => ['?', Module::CUSTOMER_ROLE],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [Module::CUSTOMER_ROLE],
                    ],
                    [
                        'allow' => true,
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
        $ticket = $this->getTicketById($ticketId);

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
            'detailView' => $this->getSupportCoreModule()->getCustomerViewDetailConfig($ticket),
        ]);
    }

    public function actionCreate()
    {
        /** @var CreateTicketForm|CreateTicketInputInterface $model */
        $model = $this->make(CreateTicketInputInterface::class);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /** @var TicketInterface $ticket */
            $ticket = Yii::$app->db->transaction(function () use ($model) {
                return $this->make(CreateTicketInterface::class)($model);
            });

            return ($this->redirectAfterCreateTicket)($this, $ticket);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAfterCreate($ticketId)
    {
        return $this->render('afterCreate', [
            'ticketId' => $ticketId,
        ]);
    }
}
