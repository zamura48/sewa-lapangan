<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Booking extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'booking_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pelanggan' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'id_jadwal' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => '10',
                'null' => true
            ],
            'subtotal' => [
                'type' => 'INT',
                'constraint' => '10',
                'null' => true
            ],
        ]);
        $this->forge->addKey('booking_id', true);
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings');
    }
}
