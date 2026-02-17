<?php

namespace Modules\Dormitory\Controllers;

use App\Controllers\BaseController;
use Modules\Dormitory\Models\DormitoryModel;

class DormitoryFrontendController extends BaseController
{
    protected $dormitoryModel;

    public function __construct()
    {
        $this->dormitoryModel = new DormitoryModel();
    }

    /**
     * Display public dormitory catalog
     */
    public function index()
    {
        $dormitories = $this->dormitoryModel->getAllWithOccupancy();

        // Filter only available and not inactive
        $dormitories = array_filter($dormitories, function($d) {
            return $d['status'] !== 'inactive';
        });

        return view('Modules\Dormitory\Views\Frontend\index', [
            'title'       => 'Dormitory',
            'dormitories' => $dormitories,
        ]);
    }

    /**
     * Display single dormitory details
     */
    public function show(string $id)
    {
        $dormitory = $this->dormitoryModel->getWithOccupancy($id);

        if (!$dormitory || $dormitory['status'] === 'inactive') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get random thumbnail
        $thumbnail = $this->dormitoryModel->getRandomThumbnail($dormitory);

        return view('Modules\Dormitory\Views\Frontend\detail', [
            'title'      => $dormitory['room_name'],
            'dormitory'  => $dormitory,
            'thumbnail'  => $thumbnail,
        ]);
    }
}
