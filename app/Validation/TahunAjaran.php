<?php

namespace App\Validation;

class TahunAjaran
{
    public function ruleStore()
    {
        return [
            'tahun_ajaran' => [
                'rules' => 'required|min_length[9]|is_unique[tbl_tahun_ajaran.tahun]',
                'errors' => [
                    'required' => 'Field tahun ajaran tidak boleh kosong',
                    'min_length' => 'Tahun ajaran minimal 9 karakter',
                    'is_unique' => 'Tahun ajaran sudah digunakan',
                ],
            ],
        ];
    }

    public function ruleUpdate($id)
    {
        return [
            'tahun_ajaran' => [
                'rules' => 'required|min_length[9]|is_unique[tbl_tahun_ajaran.tahun,id,' . $id . ']',
                'errors' => [
                    'required' => 'Field tahun ajaran tidak boleh kosong',
                    'min_length' => 'Tahun ajaran minimal 9 karakter',
                    'is_unique' => 'Tahun ajaran sudah digunakan',
                ],
            ],
        ];
    }
}
