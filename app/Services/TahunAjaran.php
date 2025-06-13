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
                    'message' => 'Tidak ada data tahun ajaran tersedia',
                    'data'    => [],
                ];
            }

            return [
                'success' => true,
                'message' => 'Berhasil mengambil data tahun ajaran',
                'data'    => $result,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
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
                    'message' => 'Gagal menambahkan data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'message' => 'Berhasil menambahkan data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
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
                    'message' => 'Data tahun ajaran tidak ditemukan'
                ];
            }

            if (!$this->tahunAjaranModel->updateData($id, $newData)) {
                return [
                    'success' => false,
                    'message' => 'Gagal update data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'message' => 'Berhasil update data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
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
                    'message' => 'Data tahun ajaran tidak ditemukan'
                ];
            }

            if (!$this->tahunAjaranModel->deleteData($id)) {
                return [
                    'success' => false,
                    'message' => 'Gagal hapus data tahun ajaran'
                ];
            }

            return [
                'success' => true,
                'message' => 'Berhasil hapus data tahun ajaran'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan : ' . $th->getMessage(),
            ];
        }
    }
}
