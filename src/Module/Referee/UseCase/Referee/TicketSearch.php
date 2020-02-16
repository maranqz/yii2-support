<?php

namespace SSupport\Module\Referee\UseCase\Referee;

use kartik\daterange\DateRangeBehavior;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Entity\Ticket;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class TicketSearch extends Ticket
{
    use ContainerAwareTrait;

    public $createAtRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'createAtRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['createAtRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['subject'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param int   $refereeId
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($refereeId, $params)
    {
        /** @var ActiveQuery $query */
        $query = $this->make(TicketInterface::class)::find()->andWhere(['referee_id' => $refereeId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'assign_id' => $this->assign_id,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['between', 'created_at', $this->createTimeStart, $this->createTimeEnd]);

        return $dataProvider;
    }
}
