<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSemesterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'semester_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_semester');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_semester');
    }
}
