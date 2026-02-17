<?php

namespace Modules\Dormitory\Models;

use CodeIgniter\Model;

class DormitoryModel extends Model
{
    protected $table            = 'dormitories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'id',
        'room_name',
        'location',
        'map_url',
        'room_capacity',
        'facilities',
        'gallery',
        'note',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'room_name'     => 'required|min_length[3]|max_length[255]',
        'location'      => 'required|max_length[500]',
        'map_url'       => 'permit_empty|max_length[500]|valid_url',
        'room_capacity' => 'required|integer|greater_than[0]',
        'status'        => 'required|in_list[available,full,maintenance,inactive]',
    ];

    protected $validationMessages = [
        'room_name' => [
            'required'   => 'Room name is required.',
            'min_length' => 'Room name must be at least 3 characters.',
        ],
        'location' => [
            'required' => 'Location is required.',
        ],
        'room_capacity' => [
            'required'    => 'Room capacity is required.',
            'greater_than' => 'Room capacity must be greater than 0.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateUUID', 'encodeJsonFields'];
    protected $beforeUpdate   = ['encodeJsonFields'];
    protected $afterFind      = ['decodeJsonFields'];

    /**
     * Generate UUID for new records
     */
    protected function generateUUID(array $data): array
    {
        if (!isset($data['data']['id'])) {
            $data['data']['id'] = $this->generateUUIDv4();
        }
        return $data;
    }

    /**
     * Generate UUID v4
     */
    private function generateUUIDv4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Encode JSON fields before save
     */
    protected function encodeJsonFields(array $data): array
    {
        $jsonFields = ['facilities', 'gallery'];

        foreach ($jsonFields as $field) {
            if (isset($data['data'][$field])) {
                if (is_array($data['data'][$field])) {
                    $data['data'][$field] = json_encode($data['data'][$field]);
                } elseif (is_string($data['data'][$field]) && !empty($data['data'][$field])) {
                    // If it's a string, try to decode and re-encode to ensure valid JSON
                    $decoded = json_decode($data['data'][$field], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $data['data'][$field] = json_encode($decoded);
                    } else {
                        // If not valid JSON, treat as comma-separated or newline-separated
                        $items = array_filter(array_map('trim', preg_split('/[\n,]+/', $data['data'][$field])));
                        $data['data'][$field] = json_encode($items);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Decode JSON fields after fetch
     */
    protected function decodeJsonFields(array $data): array
    {
        $jsonFields = ['facilities', 'gallery'];

        if (isset($data['data'])) {
            // Single record
            foreach ($jsonFields as $field) {
                if (isset($data['data'][$field]) && is_string($data['data'][$field])) {
                    $data['data'][$field] = json_decode($data['data'][$field], true) ?? [];
                }
            }
        } elseif (isset($data['id'])) {
            // Single record (alternative format)
            foreach ($jsonFields as $field) {
                if (isset($data[$field]) && is_string($data[$field])) {
                    $data[$field] = json_decode($data[$field], true) ?? [];
                }
            }
        }

        return $data;
    }

    /**
     * Get all dormitories with occupancy info
     */
    public function getAllWithOccupancy(): array
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('dormitories d')
            ->select('d.*, 
                (SELECT COUNT(*) FROM dormitory_assignments da 
                 WHERE da.dormitory_id = d.id AND da.status = "active") as occupied_beds')
            ->where('d.deleted_at', null)
            ->orderBy('d.created_at', 'DESC')
            ->get();

        $results = $query->getResultArray();

        // Decode JSON fields and calculate available beds
        foreach ($results as &$row) {
            $row['facilities'] = json_decode($row['facilities'] ?? '[]', true) ?? [];
            $row['gallery'] = json_decode($row['gallery'] ?? '[]', true) ?? [];
            $row['occupied_beds'] = (int) ($row['occupied_beds'] ?? 0);
            $row['available_beds'] = $row['room_capacity'] - $row['occupied_beds'];
        }

        return $results;
    }

    /**
     * Get dormitory with occupancy info by ID
     */
    public function getWithOccupancy(string $id): ?array
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('dormitories d')
            ->select('d.*, 
                (SELECT COUNT(*) FROM dormitory_assignments da 
                 WHERE da.dormitory_id = d.id AND da.status = "active") as occupied_beds')
            ->where('d.id', $id)
            ->where('d.deleted_at', null)
            ->get();

        $row = $query->getRowArray();

        if ($row) {
            $row['facilities'] = json_decode($row['facilities'] ?? '[]', true) ?? [];
            $row['gallery'] = json_decode($row['gallery'] ?? '[]', true) ?? [];
            $row['occupied_beds'] = (int) ($row['occupied_beds'] ?? 0);
            $row['available_beds'] = $row['room_capacity'] - $row['occupied_beds'];
        }

        return $row;
    }

    /**
     * Get available dormitories (with available beds)
     */
    public function getAvailable(): array
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('dormitories d')
            ->select('d.*, 
                (SELECT COUNT(*) FROM dormitory_assignments da 
                 WHERE da.dormitory_id = d.id AND da.status = "active") as occupied_beds')
            ->where('d.deleted_at', null)
            ->where('d.status', 'available')
            ->having('occupied_beds < d.room_capacity')
            ->orderBy('d.created_at', 'DESC')
            ->get();

        $results = $query->getResultArray();

        foreach ($results as &$row) {
            $row['facilities'] = json_decode($row['facilities'] ?? '[]', true) ?? [];
            $row['gallery'] = json_decode($row['gallery'] ?? '[]', true) ?? [];
            $row['occupied_beds'] = (int) ($row['occupied_beds'] ?? 0);
            $row['available_beds'] = $row['room_capacity'] - $row['occupied_beds'];
        }

        return $results;
    }

    /**
     * Get random thumbnail from gallery
     */
    public function getRandomThumbnail(array $dormitory): ?string
    {
        $gallery = $dormitory['gallery'] ?? [];
        if (empty($gallery)) {
            return null;
        }
        return $gallery[array_rand($gallery)];
    }
}
