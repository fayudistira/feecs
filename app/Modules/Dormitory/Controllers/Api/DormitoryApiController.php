<?php

namespace Modules\Dormitory\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Dormitory\Models\DormitoryModel;

class DormitoryApiController extends ResourceController
{
    protected $format = 'json';
    protected $dormitoryModel;

    public function __construct()
    {
        $this->dormitoryModel = new DormitoryModel();
    }

    /**
     * Get all dormitories
     */
    public function index()
    {
        $dormitories = $this->dormitoryModel->getAllWithOccupancy();

        return $this->respond([
            'status'  => 'success',
            'data'    => $dormitories,
            'message' => 'Dormitories retrieved successfully'
        ]);
    }

    /**
     * Get single dormitory
     */
    public function show($id = null)
    {
        $dormitory = $this->dormitoryModel->getWithOccupancy($id);

        if (!$dormitory) {
            return $this->failNotFound('Dormitory not found');
        }

        return $this->respond([
            'status'  => 'success',
            'data'    => $dormitory,
            'message' => 'Dormitory retrieved successfully'
        ]);
    }

    /**
     * Get available dormitories only
     */
    public function available()
    {
        $dormitories = $this->dormitoryModel->getAvailable();

        return $this->respond([
            'status'  => 'success',
            'data'    => $dormitories,
            'count'   => count($dormitories),
            'message' => 'Available dormitories retrieved successfully'
        ]);
    }
}
