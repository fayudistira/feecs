<?php

namespace Modules\Test\Controllers;

use Modules\Test\Models\TestModule;

use App\Controllers\BaseController;

class TestController extends BaseController
{
    protected $testModel;

    public function __construct()
    {
        $this->testModel = new TestModule();
    }

    public function index()
    {
        return view('Modules\Test\Views\index', [
            'title' => 'Test',
            'menu'  => [
                'index'  => base_url('test'),
                'create' => base_url('test/create'),
            ]
        ]);
    }
    public function create()
    {
        return view('Modules\Test\Views\create', [
            'title' => 'Create Test',
            'menu'  => ['index' => base_url('test')]
        ]);
    }

    public function store()
    {
        return redirect()->back()->with('success', 'Saved (static)');
    }

    public function show(int $id)
    {
        return view('Modules\Test\Views\detail', [
            'title' => 'Detail Test',
            'id'    => $id,
            'menu'  => [
                'index' => base_url('test'),
                'edit'  => base_url('test/' . $id . '/edit'),
            ]
        ]);
    }

    public function edit(int $id)
    {
        return view('Modules\Test\Views\edit', [
            'title' => 'Edit Test',
            'id'    => $id,
            'menu'  => [
                'index'  => base_url('test'),
                'detail' => base_url('test/' . $id),
            ]
        ]);
    }

    public function update(int $id)
    {
        return redirect()->back()->with('success', 'Updated (static)');
    }

    public function delete(int $id)
    {
        return redirect()->to(base_url('test'))->with('success', 'Deleted (static)');
    }
}