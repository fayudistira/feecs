<?php

namespace Modules\Test\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Test\Models\TestRegistrationModel;

class TestApiController extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new TestRegistrationModel();
    }

    /**
     * Get all HSK registrations
     * 
     * GET /api/test/hsk-registrations
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getHskRegistrations()
    {
        $status = $this->request->getGet('status');
        $level = $this->request->getGet('level');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 20;

        $builder = $this->model->builder();

        if ($status) {
            $builder->where('status', $status);
        }

        if ($level) {
            $builder->where('hsk_level', $level);
        }

        $total = $builder->countAllResults(false);
        $registrations = $this->model->orderBy('created_at', 'DESC')
                                     ->paginate($perPage, 'default', $page);

        return $this->respond([
            'success' => true,
            'data' => $registrations,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => ceil($total / $perPage),
            ],
        ]);
    }

    /**
     * Get single HSK registration
     * 
     * GET /api/test/hsk-registrations/{id}
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getHskRegistration(int $id)
    {
        $registration = $this->model->find($id);

        if (!$registration) {
            return $this->respond([
                'success' => false,
                'message' => 'Registrasi tidak ditemukan',
            ], 404);
        }

        return $this->respond([
            'success' => true,
            'data' => $registration,
        ]);
    }

    /**
     * Create new HSK registration
     * 
     * POST /api/test/hsk-registrations
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function createHskRegistration()
    {
        $data = $this->request->getJSON();

        if (!$data) {
            return $this->respond([
                'success' => false,
                'message' => 'Data tidak valid',
            ], 400);
        }

        // Validate required fields
        $requiredFields = ['hsk_level', 'full_name', 'email', 'phone'];
        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                return $this->respond([
                    'success' => false,
                    'message' => "Field $field wajib diisi",
                ], 400);
            }
        }

        // Check for duplicate
        if ($this->model->isEmailRegistered($data->email, $data->hsk_level)) {
            return $this->respond([
                'success' => false,
                'message' => 'Email ini sudah terdaftar untuk tingkat HSK yang sama',
            ], 400);
        }

        $insertData = [
            'hsk_level' => $data->hsk_level,
            'full_name' => $data->full_name,
            'email' => $data->email,
            'phone' => $data->phone,
            'birth_date' => $data->birth_date ?? null,
            'address' => $data->address ?? null,
            'education' => $data->education ?? null,
            'occupation' => $data->occupation ?? null,
            'mandarin_level' => $data->mandarin_level ?? null,
            'notes' => $data->notes ?? null,
            'status' => 'pending',
        ];

        try {
            $insertId = $this->model->insert($insertData);

            if ($insertId) {
                return $this->respond([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil',
                    'data' => [
                        'id' => $insertId,
                        ...$insertData,
                    ],
                ], 201);
            } else {
                return $this->respond([
                    'success' => false,
                    'message' => 'Gagal menyimpan pendaftaran',
                ], 500);
            }
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update HSK registration
     * 
     * PUT /api/test/hsk-registrations/{id}
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function updateHskRegistration(int $id)
    {
        $registration = $this->model->find($id);

        if (!$registration) {
            return $this->respond([
                'success' => false,
                'message' => 'Registrasi tidak ditemukan',
            ], 404);
        }

        $data = $this->request->getJSON();

        if (!$data) {
            return $this->respond([
                'success' => false,
                'message' => 'Data tidak valid',
            ], 400);
        }

        $updateData = [];

        $allowedFields = ['hsk_level', 'full_name', 'email', 'phone', 'birth_date', 'address', 'education', 'occupation', 'mandarin_level', 'notes'];

        foreach ($allowedFields as $field) {
            if (isset($data->$field)) {
                $updateData[$field] = $data->$field;
            }
        }

        if (empty($updateData)) {
            return $this->respond([
                'success' => false,
                'message' => 'Tidak ada data untuk diperbarui',
            ], 400);
        }

        try {
            $result = $this->model->update($id, $updateData);

            if ($result) {
                return $this->respond([
                    'success' => true,
                    'message' => 'Data berhasil diperbarui',
                    'data' => $this->model->find($id),
                ]);
            } else {
                return $this->respond([
                    'success' => false,
                    'message' => 'Gagal memperbarui data',
                ], 500);
            }
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete HSK registration
     * 
     * DELETE /api/test/hsk-registrations/{id}
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function deleteHskRegistration(int $id)
    {
        $registration = $this->model->find($id);

        if (!$registration) {
            return $this->respond([
                'success' => false,
                'message' => 'Registrasi tidak ditemukan',
            ], 404);
        }

        try {
            $this->model->delete($id);

            return $this->respond([
                'success' => true,
                'message' => 'Registrasi berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update registration status
     * 
     * POST /api/test/hsk-registrations/{id}/status
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function updateStatus(int $id)
    {
        $registration = $this->model->find($id);

        if (!$registration) {
            return $this->respond([
                'success' => false,
                'message' => 'Registrasi tidak ditemukan',
            ], 404);
        }

        $data = $this->request->getJSON();
        $status = $data->status ?? null;

        if (!$status || !in_array($status, ['pending', 'contacted', 'confirmed', 'cancelled'])) {
            return $this->respond([
                'success' => false,
                'message' => 'Status tidak valid',
            ], 400);
        }

        try {
            $this->model->updateStatus($id, $status);

            return $this->respond([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'data' => [
                    'id' => $id,
                    'status' => $status,
                ],
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
