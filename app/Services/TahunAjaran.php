<?php

namespace App\Services;

use App\Models\TahunAjaran as ModelsTahunAjaran;

class TahunAjaran
{
    protected $tahunAjaranModel;
    public function __construct()
    {
        $this->tahunAjaranModel = new ModelsTahunAjaran();
    }

    public function getData()
    {
        try {
            $result = $this->tahunAjaranModel->findAllData();
            if (empty($result)) {
                return [
                    'success' => true,
                    'data'    => [],
                ];
            }

            return [
                'success' => true,
                'data'    => $result,
            ];
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'data'    => [],
            ];
        }
    }

    public function createTahunAjaran($data)
    {
        $newData = [
            'tahun' => ucwords(strtolower($data['tahun']))
        ];

        try {
            if (!$this->tahunAjaranModel->saveData($newData)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal menambahkan data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'code'    => 201,
                'message' => 'Berhasil menambahkan data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }

    public function updateTahunAjaran($id, $data)
    {
        $newData = [
            'tahun'      => ucwords(strtolower($data['tahun'])),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try {
            $existing = $this->tahunAjaranModel->findById($id);
            if (!$existing) {
                return [
                    'success' => false,
                    'code'    => 404,
                    'message' => 'Data tahun ajaran tidak ditemukan'
                ];
            }

            if (!$this->tahunAjaranModel->updateData($id, $newData)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal update data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'code'    => 200,
                'message' => 'Berhasil update data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }

    public function deleteTahunAjaran($id)
    {
        try {
            $existing = $this->tahunAjaranModel->findById($id);
            if (!$existing) {
                return [
                    'success' => false,
                    'code'    => 404,
                    'message' => 'Data tahun ajaran tidak ditemukan'
                ];
            }

            if (!$this->tahunAjaranModel->deleteData($id)) {
                return [
                    'success' => false,
                    'code'    => 500,
                    'message' => 'Gagal hapus data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'code'    => 200,
                'message' => 'Berhasil hapus data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }
}
