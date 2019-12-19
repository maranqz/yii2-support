<?php

namespace SSupport\Module\Core\Controller\customer\ticket;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicketInterface;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Entity\TicketSearch;
use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class IndexController extends Controller
{
    use ContainerAwareTrait;

    const PATH = 'customer/ticket/index';

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

    public function actionIndex()
    {
        $searchModel = $this->make(TicketSearch::class);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $ticket = $this->findModel($id);
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

            return $this->redirect(['view', 'id' => $ticket->getId()]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (null !== ($model = Ticket::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('ssupport', 'The requested page does not exist.'));
    }
}
