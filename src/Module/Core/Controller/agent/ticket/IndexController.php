<?php

namespace SSupport\Module\Core\Controller\agent\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Module;
use SSupport\Module\Core\Resource\config\GridView\AgentGridViewSettingsInterface;
use SSupport\Module\Core\UseCase\Agent\TicketSearch;
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

    const PATH = 'agent/ticket/index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Module::AGENT_ROLE],
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
        $ticket = $this->findModel($ticketId);
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

    protected function findModel($id)
    {
        if (null !== ($model = $this->make(TicketInterface::class)::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('ssupport', 'The requested page does not exist.'));
    }
}
