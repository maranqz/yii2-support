<?php

namespace SSupport\Module\Core\Resource\config\GridView;

use SSupport\Module\Core\Utils\CoreModuleAwareTrait;
use yii\grid\ActionColumn;

abstract class AbstractGridViewSettings implements CommonGridViewSettingsInterface
{
    use CoreModuleAwareTrait;

    protected $dataProvider;
    protected $searchModel;
    protected $urlCreator;

    public function __construct($dataProvider, $searchModel, $urlCreator)
    {
        $this->dataProvider = $dataProvider;
        $this->searchModel = $searchModel;
        $this->urlCreator = $urlCreator;
    }

    public function id()
    {
        return [
            'attribute' => 'id',
            'headerOptions' => [
                'class' => 'cell_id',
            ],
            'filterOptions' => [
                'class' => 'cell_id',
            ],
            'contentOptions' => [
                'class' => 'cell_id',
            ],
        ];
    }

    public function subject()
    {
        return [
            'attribute' => 'subject',
            'headerOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
            'filterOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
            'contentOptions' => [
                'class' => 'text-truncate cell_subject',
            ],
        ];
    }

    public function actionColumn()
    {
        return [
            'class' => ActionColumn::class,
            'urlCreator' => $this->urlCreator,
            'template' => '{view}',
        ];
    }

    public function dataProvider()
    {
        return $this->dataProvider;
    }

    public function searchModel()
    {
        return $this->searchModel;
    }
}
