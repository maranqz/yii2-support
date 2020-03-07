<?php

namespace SSupport\Module\Referee\Controller\referee\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Controller\BlockTrait;
use SSupport\Module\Core\Gateway\Highlighting\HighlighterInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use SSupport\Module\Referee\Module;
use SSupport\Module\Referee\Resource\config\GridView\RefereeGridViewSettingsInterface;
use SSupport\Module\Referee\UseCase\Referee\TicketSearch;
use SSupport\Module\Referee\Utils\RefereeModuleAwareTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
{
    use BlockTrait;
    use ContainerAwareTrait;
    use CoreModuleAwareTrait;
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
                        /*
                         * @TODO setting block only set ticket
                         */
                        'allow' => true,
                        'roles' => [Module::REFEREE_ROLE],
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
            'detailView' => $this->getSupportRefereeModule()->getRefereeViewDetailConfig($ticket),
        ]);
    }

    protected function findModel($id)
    {
        /** @var TicketInterface $model */
        if (null !== ($model = $this->make(TicketInterface::class)::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException();
    }
}
