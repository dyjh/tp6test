<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Student extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('student');
        $table->setId('sno', 'biginteger', ['limit' => 20, 'null' => false, 'comment' => '学生编号'])
            ->addColumn('sname', 'string', ['limit' => 4, 'null' => false, 'comment' => '学生姓名'])
            ->addColumn('ssex', 'bit', ['limit' => 2, 'null' => false, 'comment' => '性别（0=男 1=女）'])
            ->addColumn('sbrithday', 'datetime', ['null' => false, 'comment' => '生日'])
            ->addColumn('class', 'string', ['limit' => 5, 'null' => true, 'comment' => '班级号'])
            ->setEngine('innodb')
            ->create();
    }
}
