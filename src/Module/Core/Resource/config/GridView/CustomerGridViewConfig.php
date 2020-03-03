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
            'label' => Yii::t('ssupport_core', 'Assign'),
            'value' => 'assigns.0.nickname',
        ];
    }

    public function updatedAt()
    {
        return [
            'headerOptions' => [
                'class' => 'cell_updated_at',
            ],
            'attribute' => 'updated_at',
            'format' => 'datetime',
        ];
    }
}
