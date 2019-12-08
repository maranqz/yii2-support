<?php

namespace SSupport\Module\Core\Controller;

use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Component\Core\UseCase\Customer\CreateTicket\CreateTicket;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Entity\TicketSearch;
use SSupport\Module\Core\UseCase\Customer\CreateTicketForm;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CustomerController extends Controller
{
    use ContainerAwareTrait;

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
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = $this->make(CreateTicketForm::class);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /** @var TicketInterface $ticket */
            $ticket = $this->make(CreateTicket::class)($model);

            return $this->redirect(['view', 'id' => $ticket->getId()]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSendMessage()
    {
        $model = new SendMessageForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /** @var TicketInterface $ticket */
            $ticket = $this->make(CreateTicket::class)($model);

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
