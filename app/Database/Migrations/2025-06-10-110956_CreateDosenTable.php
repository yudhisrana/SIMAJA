<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDosenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'nidn' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nidn');
        $this->forge->addForeignKey('user_id', 'tbl_user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_dosen');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_dosen');
    }
}
