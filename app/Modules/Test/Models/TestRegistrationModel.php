<?php

namespace Modules\Test\Models;

use CodeIgniter\Model;

class TestRegistrationModel extends Model
{
    protected $table            = 'test_registrations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'hsk_level',
        'full_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'education',
        'occupation',
        'mandarin_level',
        'notes',
        'status',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'hsk_level'   => 'required|max_length[50]',
        'full_name'  => 'required|max_length[255]',
        'email'      => 'required|valid_email|max_length[255]',
        'phone'      => 'required|max_length[20]',
        'birth_date' => 'permit_empty|valid_date',
        'address'    => 'permit_empty',
        'education'  => 'permit_empty|max_length[50]',
        'occupation' => 'permit_empty|max_length[100]',
        'mandarin_level' => 'permit_empty|max_length[50]',
        'notes'      => 'permit_empty',
        'status'     => 'permit_empty|in_list[pending,contacted,confirmed,cancelled]',
    ];

    protected $validationMessages = [
        'hsk_level' => [
            'required' => 'Tingkat HSK wajib diisi.',
        ],
        'full_name' => [
            'required' => 'Nama lengkap wajib diisi.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'phone' => [
            'required' => 'Nomor WhatsApp wajib diisi.',
        ],
    ];

    /**
     * Get registrations by status
     */
    public function getByStatus(string $status): array
    {
        return $this->where('status', $status)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get registrations by HSK level
     */
    public function getByLevel(string $level): array
    {
        return $this->where('hsk_level', $level)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Check if email already registered for a specific level
     */
    public function isEmailRegistered(string $email, string $level): bool
    {
        return $this->where('email', $email)
                    ->where('hsk_level', $level)
                    ->countAllResults() > 0;
    }

    /**
     * Update registration status
     */
    public function updateStatus(int $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats(): array
    {
        return [
            'total' => $this->countAll(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'contacted' => $this->where('status', 'contacted')->countAllResults(),
            'confirmed' => $this->where('status', 'confirmed')->countAllResults(),
            'cancelled' => $this->where('status', 'cancelled')->countAllResults(),
        ];
    }

    /**
     * Get recent registrations
     */
    public function getRecent(int $limit = 10): array
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get registrations by date range
     */
    public function getByDateRange(string $startDate, string $endDate): array
    {
        return $this->where('created_at >=', $startDate)
                    ->where('created_at <=', $endDate)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
