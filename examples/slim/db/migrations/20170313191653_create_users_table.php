<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $users = $this->table('users', ['id' => false, 'primary_key' => 'id']);
        $users->addColumn('id', 'string', ['null' => false, 'limit' => 40]);
        $users->addColumn('name', 'string', ['null' => false, 'limit' => 255]);
        $users->addColumn('surname', 'string', ['null' => false, 'limit' => 255]);
        $users->addColumn('email', 'string', ['null' => false, 'limit' => 255]);
        $users->addColumn('password', 'string', ['null' => false, 'limit' => 255]);
        $users->create();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
