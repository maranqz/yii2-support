<?php

namespace SSupport\Module\Core\Controller\agent\ticket;

use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\RBAC\IsOwnerAgentRule;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\UseCase\Agent\TicketSearch;
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

    const PATH = 'agent/ticket/index';

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
                        'actions' => ['index'],
                        'roles' => [Module::AGENT_ROLE],
                    ],
                    [
                        'allow' => true,
                        'permissions' => [IsOwnerAgentRule::NAME],
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
        $searchModel = $this->make(TicketSearch::class);
        $dataProvider = $searchModel->search(Yii::$app->user->getId(), Yii::$app->request->queryParams);

        $gridViewSettings = $this->make(
            AgentGridViewSettingsInterface::class,
            [$dataProvider, $searchModel, $this->getSupportCoreModule()->urlCreateGrid]
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridViewConfig' => ($this->getSupportCoreModule()->agentGridViewConfig)($gridViewSettings),
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
            'detailView' => $this->getSupportCoreModule()->getAgentViewDetailConfig($ticket),
        ]);
    }
}
