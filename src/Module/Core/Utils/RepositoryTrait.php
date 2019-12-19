<?php

namespace SSupport\Module\Core\Utils;

use SSupport\Module\Core\Exception\ValidationException;
use yii\db\ActiveRecordInterface;

trait RepositoryTrait
{
    protected function trySave(ActiveRecordInterface $model)
    {
        if (false === $model->save()) {
            throw new ValidationException($model->getErrors());
        }

        return $this;
    }

    protected function tryDelete(ActiveRecordInterface $model)
    {
        $model->delete();

        return $this;
    }
}
