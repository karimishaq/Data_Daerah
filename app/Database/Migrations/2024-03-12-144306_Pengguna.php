<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengguna extends Migration
{
    public function up()
    {
        //
        $this->forge->addField(array(
            'id_pengguna' => array(
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ),
            'username' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),'foto' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
        ));
        $this->forge->addKey('id_pengguna', true);
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        //
        $this->forge->dropTable('pengguna');
    }
}
