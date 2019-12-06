<?php

use yii\db\Migration;

class m191206_202249_create_attachment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'size' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%attachment}}');
    }
}
