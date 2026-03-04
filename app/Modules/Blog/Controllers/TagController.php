<?php

/**
 * Tag Controller
 * 
 * Handles tag management for the blog.
 */

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\BlogTagModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class TagController extends BaseController
{
    protected $tagModel;

    public function __construct()
    {
        $this->tagModel = new BlogTagModel();
    }

    /**
     * List all tags
     */
    public function index()
    {
        $data['tags'] = $this->tagModel->getTagsWithPostCount();
        
        return view('Modules\Blog\Views\admin\tags\index', $data);
    }

    /**
     * Store new tag (AJAX)
     */
    public function store()
    {
        $name = $this->request->getPost('name');
        
        if (empty($name)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tag name is required'
            ]);
        }

        try {
            $tagId = $this->tagModel->createTag($name);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Tag created successfully!',
                'tag_id' => $tagId,
                'tag_name' => $name
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create tag: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete tag
     */
    public function delete(int $id): RedirectResponse
    {
        $tag = $this->tagModel->find($id);
        
        if (!$tag) {
            return redirect()->to('admin/blog/tags')
                ->with('error', 'Tag not found!');
        }

        try {
            $this->tagModel->delete($id);
            
            return redirect()->to('admin/blog/tags')
                ->with('success', 'Tag deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->to('admin/blog/tags')
                ->with('error', 'Failed to delete tag: ' . $e->getMessage());
        }
    }

    /**
     * Search tags (AJAX)
     */
    public function search()
    {
        $query = $this->request->getGet('q');
        
        if (empty($query)) {
            return $this->response->setJSON([]);
        }

        $tags = $this->tagModel->like('name', $query)->findAll(10);
        
        return $this->response->setJSON($tags);
    }
}
