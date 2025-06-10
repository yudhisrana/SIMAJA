<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageColumnUserTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_user', [
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'    => 'gender',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user', 'image');
    }
}
