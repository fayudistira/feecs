<?php

namespace Modules\Academic\Controllers;


use App\Controllers\BaseController;

class AcademicController extends BaseController
{

    public function index()
    {
        return view('Modules\Academic\Views\index', [
            'title' => 'Academic',
            'menu'  => [
                'index'  => base_url('academic'),
                'create' => base_url('academic/create'),
            ]
        ]);
    }
    public function create()
    {
        return view('Modules\Academic\Views\create', [
            'title' => 'Create Academic',
            'menu'  => ['index' => base_url('academic')]
        ]);
    }

    public function store()
    {
        return redirect()->back()->with('success', 'Saved (static)');
    }

    public function show(int $id)
    {
        return view('Modules\Academic\Views\detail', [
            'title' => 'Detail Academic',
            'id'    => $id,
            'menu'  => [
                'index' => base_url('academic'),
                'edit'  => base_url('academic/' . $id . '/edit'),
            ]
        ]);
    }

    public function edit(int $id)
    {
        return view('Modules\Academic\Views\edit', [
            'title' => 'Edit Academic',
            'id'    => $id,
            'menu'  => [
                'index'  => base_url('academic'),
                'detail' => base_url('academic/' . $id),
            ]
        ]);
    }

    public function update(int $id)
    {
        return redirect()->back()->with('success', 'Updated (static)');
    }

    public function delete(int $id)
    {
        return redirect()->to(base_url('academic'))->with('success', 'Deleted (static)');
    }
}