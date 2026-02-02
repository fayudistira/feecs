<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class FileController extends BaseController
{
    /**
     * Serve uploaded files from writable/uploads directory
     */
    public function serve(...$segments): ResponseInterface
    {
        // Reconstruct the file path from all segments
        $filePath = implode('/', $segments);
        $fullPath = WRITEPATH . 'uploads/' . $filePath;
        
        // Always log for debugging (even in production for now)
        log_message('info', 'FileController::serve - Segments: ' . json_encode($segments));
        log_message('info', 'FileController::serve - Requested path: ' . $filePath);
        log_message('info', 'FileController::serve - Full path: ' . $fullPath);
        log_message('info', 'FileController::serve - WRITEPATH: ' . WRITEPATH);
        
        // Security check - prevent directory traversal
        $realPath = realpath($fullPath);
        $uploadsPath = realpath(WRITEPATH . 'uploads/');
        
        log_message('info', 'FileController::serve - Real path: ' . ($realPath ?: 'NULL'));
        log_message('info', 'FileController::serve - Uploads path: ' . ($uploadsPath ?: 'NULL'));
        
        if (!$realPath || !$uploadsPath || strpos($realPath, $uploadsPath) !== 0) {
            log_message('error', 'FileController::serve - Security check failed for: ' . $filePath);
            log_message('error', 'FileController::serve - realPath: ' . ($realPath ?: 'NULL') . ', uploadsPath: ' . ($uploadsPath ?: 'NULL'));
            return $this->response->setStatusCode(404, 'File not found');
        }
        
        // Check if file exists
        if (!file_exists($fullPath) || !is_file($fullPath)) {
            log_message('error', 'FileController::serve - File not found: ' . $fullPath);
            log_message('error', 'FileController::serve - file_exists: ' . (file_exists($fullPath) ? 'true' : 'false'));
            log_message('error', 'FileController::serve - is_file: ' . (is_file($fullPath) ? 'true' : 'false'));
            return $this->response->setStatusCode(404, 'File not found');
        }
        
        // Check if file is readable
        if (!is_readable($fullPath)) {
            log_message('error', 'FileController::serve - File not readable: ' . $fullPath);
            return $this->response->setStatusCode(403, 'Access denied');
        }
        
        log_message('info', 'FileController::serve - File found and readable, serving...');
        
        // Get mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fullPath);
        finfo_close($finfo);
        
        log_message('info', 'FileController::serve - MIME type: ' . $mimeType);
        
        // Set headers and return file
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Length', (string) filesize($fullPath))
            ->setHeader('Cache-Control', 'public, max-age=31536000') // Cache for 1 year
            ->setBody(file_get_contents($fullPath));
    }
}
