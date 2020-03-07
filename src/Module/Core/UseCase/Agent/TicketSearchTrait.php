<?php

namespace SSupport\Module\Core\UseCase\Agent;

use kartik\daterange\DateRangeBehavior;
use SSupport\Component\Core\Entity\TicketInterface;
use SSupport\Module\Core\Utils\ContainerAwareTrait;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

trait TicketSearchTrait
{
    use ContainerAwareTrait;

    public $updatedAtRange;
    public $updatedTimeStart;
    public $updatedTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'updatedAtRange',
                'dateStartAttribute' => 'updatedTimeStart',
                'dateEndAttribute' => 'updatedTimeStart',
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
            [['updatedAtRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
     * @param int $assignId
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($assignId, $params)
    {
        /** @var ActiveQuery $query */
        $query = $this->make(TicketInterface::class)::find()->andWhere(['assign_id' => $assignId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
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
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['between', 'updated_at', $this->updatedTimeStart, $this->updatedTimeEnd]);

        return $dataProvider;
    }
}
