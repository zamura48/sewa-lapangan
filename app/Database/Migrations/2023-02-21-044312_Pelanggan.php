<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pelanggan_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'noHp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
        ]);
        $this->forge->addKey('pelanggan_id', true);
        $this->forge->createTable('pelanggans');
    }

    public function down()
    {
        $this->forge->dropTable('pelanggans');
    }
}
