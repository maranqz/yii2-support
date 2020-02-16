<?php

namespace SSupport\Module\Core\Resource\config\GridView;

interface CommonGridViewSettingsInterface
{
    public function id();

    public function subject();

    public function createdAt();

    public function actionColumn();

    public function dataProvider();

    public function searchModel();
}
