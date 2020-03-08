<?php

namespace SSupport\Module\Referee\Controller\referee\ticket;

use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use SSupport\Module\Core\Gateway\Repository\GetTicketByIdTrait;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use SSupport\Module\Referee\Module;
use SSupport\Module\Referee\RBAC\IsOwnerRefereeRule;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\UseCase\Referee\TicketSearch;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;
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
    use RefereeModuleAwareTrait;

    const PATH = 'referee/ticket/index';

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
                        'roles' => [Module::REFEREE_ROLE],
                    ],
                    [
                        'allow' => true,
                        'permissions' => [IsOwnerRefereeRule::NAME],
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
            RefereeGridViewSettingsInterface::class,
            [$dataProvider, $searchModel, $this->getSupportCoreModule()->urlCreateGrid]
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridViewConfig' => $this->getSupportRefereeModule()->getRefereeGridViewConfig($gridViewSettings),
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
            'detailView' => $this->getSupportRefereeModule()->getRefereeViewDetailConfig($ticket),
        ]);
    }
}
