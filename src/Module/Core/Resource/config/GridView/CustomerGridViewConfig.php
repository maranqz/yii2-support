<?php

namespace SSupport\Module\Core\Resource\config\GridView;

use Yii;

class CustomerGridViewConfig extends AbstractGridViewSettings implements CustomerGridViewSettingsInterface
{
    public function assign()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_assign',
            ],
            'label' => Yii::t('ssupport', 'Assign'),
            'value' => 'assigns.0.nickname',
        ];
    }

    public function createdAt()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_created_at',
            ],
            'attribute' => 'created_at',
            'format' => 'datetime',
        ];
    }
}
