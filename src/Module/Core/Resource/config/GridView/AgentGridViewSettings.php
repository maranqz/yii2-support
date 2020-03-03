<?php

namespace SSupport\Module\Core\Resource\config\GridView;

use kartik\daterange\DateRangePicker;
use Yii;
use yii\grid\ActionColumn;

class AgentGridViewSettings extends AbstractGridViewSettings implements AgentGridViewSettingsInterface
{
    public function customer()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_customer',
            ],
            'label' => Yii::t('ssupport_core', 'Customer'),
            'value' => 'customer.nickname',
        ];
    }

    public function updatedAt()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_updated_at',
            ],
            'filter' => DateRangePicker::widget([
                'model' => $this->searchModel(),
                'attribute' => 'updatedAtRange',
                'convertFormat' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd.m.Y H:i', //DD.MM.YYYY
                    ],
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerIncrement' => 15,
                ],
            ]),
            'attribute' => 'updated_at',
            'format' => 'datetime',
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
}
