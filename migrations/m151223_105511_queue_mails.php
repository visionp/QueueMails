<?php

use yii\db\Schema;
use yii\db\Migration;

class m151223_105511_queue_mails extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%queue_mails}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'subject' => $this->string(),
            'data' => $this->text()->notNull(),
            'error' => $this->text(),
            'status' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%queue_mails}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
