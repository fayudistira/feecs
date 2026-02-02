# Academic Module - Design Document

## 1. Architecture Overview

### 1.1 Module Structure
```
app/Modules/Academic/
├── Config/
│   ├── Routes.php          # Route definitions
│   └── Menu.php            # Menu configuration
├── Controllers/
│   ├── ClassController.php      # Class CRUD operations
│   └── ClassMemberController.php # Member management
├── Models/
│   ├── ClassModel.php           # Class data access
│   └── ClassMemberModel.php     # Member data access
└── Views/
    ├── classes/
    │   ├── index.php           # List all classes
    │   ├── create.php          # Create class form
    │   ├── edit.php            # Edit class form
    │   ├── view.php            # Class details + members
    │   └── assign_students.php # Assign students interface
    └── members/
        ├── index.php           # All enrollments
        └── view.php            # Member details
```

### 1.2 Database Schema

#### Classes Table
```sql
CREATE TABLE `classes` (
    `id` CHAR(36) NOT NULL PRIMARY KEY,
    `class_name` VARCHAR(100) NOT NULL,
    `class_category` VARCHAR(100) NOT NULL,
    `class_level` ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    `class_batch` VARCHAR(50) NOT NULL,
    `status` ENUM('draft', 'active', 'ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'draft',
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `max_students` INT NULL,
    `description` TEXT NULL,
    `instructor_name` VARCHAR(100) NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME NULL,
    INDEX `idx_status` (`status`),
    INDEX `idx_category` (`class_category`),
    INDEX `idx_dates` (`start_date`, `end_date`),
    INDEX `idx_deleted` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### Class Members Table
```sql
CREATE TABLE `class_members` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `class_id` CHAR(36) NOT NULL,
    `registration_number` VARCHAR(20) NOT NULL,
    `enrollment_date` DATE NOT NULL,
    `status` ENUM('active', 'dropped', 'completed', 'suspended') NOT NULL DEFAULT 'active',
    `notes` TEXT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME NULL,
    FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`registration_number`) REFERENCES `admissions`(`registration_number`) ON DELETE CASCADE,
    UNIQUE KEY `unique_enrollment` (`class_id`, `registration_number`, `deleted_at`),
    INDEX `idx_class` (`class_id`),
    INDEX `idx_student` (`registration_number`),
    INDEX `idx_status` (`status`),
    INDEX `idx_deleted` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 2. Component Design

### 2.1 Routes Configuration

**File**: `app/Modules/Academic/Config/Routes.php`

```php
<?php

$routes->group('academic', ['namespace' => 'Modules\Academic\Controllers', 'filter' => 'session'], function($routes) {
    // Class routes
    $routes->get('classes', 'ClassController::index');
    $routes->get('classes/create', 'ClassController::create');
    $routes->post('classes/store', 'ClassController::store');
    $routes->get('classes/view/(:segment)', 'ClassController::view/$1');
    $routes->get('classes/edit/(:segment)', 'ClassController::edit/$1');
    $routes->post('classes/update/(:segment)', 'ClassController::update/$1');
    $routes->post('classes/delete/(:segment)', 'ClassController::delete/$1');
    
    // Student assignment routes
    $routes->get('classes/assign/(:segment)', 'ClassController::assignStudents/$1');
    $routes->post('classes/enroll/(:segment)', 'ClassController::enrollStudents/$1');
    
    // Class member routes
    $routes->get('members', 'ClassMemberController::index');
    $routes->get('members/view/(:num)', 'ClassMemberController::view/$1');
    $routes->post('members/updateStatus/(:num)', 'ClassMemberController::updateStatus/$1');
    $routes->post('members/remove/(:num)', 'ClassMemberController::remove/$1');
    $routes->get('members/export/(:segment)', 'ClassMemberController::export/$1');
});
```

### 2.2 Menu Configuration

**File**: `app/Modules/Academic/Config/Menu.php`

```php
<?php

return [
    'academic' => [
        'title' => 'Academic',
        'icon' => 'bi-book',
        'url' => '/academic/classes',
        'order' => 40,
        'children' => [
            [
                'title' => 'Classes',
                'icon' => 'bi-book',
                'url' => '/academic/classes'
            ],
            [
                'title' => 'Enrollments',
                'icon' => 'bi-people',
                'url' => '/academic/members'
            ]
        ]
    ]
];
```

---

## 3. Model Implementation

### 3.1 ClassModel

**File**: `app/Modules/Academic/Models/ClassModel.php`

```php
<?php

namespace Modules\Academic\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'id', 'class_name', 'class_category', 'class_level', 'class_batch',
        'status', 'start_date', 'end_date', 'max_students', 'description',
        'instructor_name'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'class_name' => 'required|min_length[3]|max_length[100]',
        'class_category' => 'required|min_length[3]|max_length[100]',
        'class_level' => 'required|in_list[beginner,intermediate,advanced]',
        'class_batch' => 'required|min_length[2]|max_length[50]',
        'status' => 'required|in_list[draft,active,ongoing,completed,cancelled]',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'max_students' => 'permit_empty|integer|greater_than[0]',
        'description' => 'permit_empty|max_length[1000]',
        'instructor_name' => 'permit_empty|min_length[3]|max_length[100]'
    ];
    
    protected $validationMessages = [
        'class_name' => [
            'required' => 'Class name is required',
            'min_length' => 'Class name must be at least 3 characters'
        ]
    ];
    
    protected $beforeInsert = ['generateUuid'];
    protected $beforeUpdate = ['validateEndDate'];
    
    protected function generateUuid(array $data)
    {
        if (!isset($data['data']['id'])) {
            helper('text');
            $data['data']['id'] = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }
    
    protected function validateEndDate(array $data)
    {
        if (isset($data['data']['start_date']) && isset($data['data']['end_date'])) {
            if (strtotime($data['data']['end_date']) <= strtotime($data['data']['start_date'])) {
                throw new \Exception('End date must be after start date');
            }
        }
        return $data;
    }
    
    public function getClassWithStats($id)
    {
        return $this->select('classes.*, 
            COUNT(CASE WHEN class_members.status = "active" AND class_members.deleted_at IS NULL THEN 1 END) as active_members,
            COUNT(CASE WHEN class_members.deleted_at IS NULL THEN 1 END) as total_members')
            ->join('class_members', 'class_members.class_id = classes.id', 'left')
            ->where('classes.id', $id)
            ->groupBy('classes.id')
            ->first();
    }
    
    public function getAllWithStats()
    {
        return $this->select('classes.*, 
            COUNT(CASE WHEN class_members.status = "active" AND class_members.deleted_at IS NULL THEN 1 END) as active_members,
            COUNT(CASE WHEN class_members.deleted_at IS NULL THEN 1 END) as total_members')
            ->join('class_members', 'class_members.class_id = classes.id', 'left')
            ->groupBy('classes.id')
            ->orderBy('classes.created_at', 'DESC')
            ->findAll();
    }
    
    public function search($keyword, $filters = [])
    {
        $builder = $this->select('classes.*, 
            COUNT(CASE WHEN class_members.status = "active" AND class_members.deleted_at IS NULL THEN 1 END) as active_members,
            COUNT(CASE WHEN class_members.deleted_at IS NULL THEN 1 END) as total_members')
            ->join('class_members', 'class_members.class_id = classes.id', 'left')
            ->groupBy('classes.id');
        
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('class_name', $keyword)
                ->orLike('class_category', $keyword)
                ->orLike('class_batch', $keyword)
                ->groupEnd();
        }
        
        if (!empty($filters['status'])) {
            $builder->where('classes.status', $filters['status']);
        }
        
        if (!empty($filters['category'])) {
            $builder->where('classes.class_category', $filters['category']);
        }
        
        if (!empty($filters['level'])) {
            $builder->where('classes.class_level', $filters['level']);
        }
        
        return $builder->orderBy('classes.created_at', 'DESC')->findAll();
    }
    
    public function hasCapacity($classId): bool
    {
        $class = $this->find($classId);
        
        if (!$class || !$class['max_students']) {
            return true;
        }
        
        $memberModel = new ClassMemberModel();
        $currentCount = $memberModel->where('class_id', $classId)
            ->where('status', 'active')
            ->countAllResults();
        
        return $currentCount < $class['max_students'];
    }
}
```

### 3.2 ClassMemberModel

**File**: `app/Modules/Academic/Models/ClassMemberModel.php`

```php
<?php

namespace Modules\Academic\Models;

use CodeIgniter\Model;

class ClassMemberModel extends Model
{
    protected $table = 'class_members';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'class_id', 'registration_number', 'enrollment_date', 'status', 'notes'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'class_id' => 'required',
        'registration_number' => 'required',
        'enrollment_date' => 'required|valid_date',
        'status' => 'required|in_list[active,dropped,completed,suspended]',
        'notes' => 'permit_empty|max_length[500]'
    ];
    
    public function getMembersWithStudents($classId)
    {
        return $this->select('class_members.*, admissions.full_name, admissions.email, admissions.phone')
            ->join('admissions', 'admissions.registration_number = class_members.registration_number')
            ->where('class_members.class_id', $classId)
            ->orderBy('class_members.enrollment_date', 'DESC')
            ->findAll();
    }
    
    public function isEnrolled($classId, $registrationNumber): bool
    {
        return $this->where('class_id', $classId)
            ->where('registration_number', $registrationNumber)
            ->countAllResults() > 0;
    }
    
    public function getStudentHistory($registrationNumber)
    {
        return $this->select('class_members.*, classes.class_name, classes.class_category, classes.class_level')
            ->join('classes', 'classes.id = class_members.class_id')
            ->where('class_members.registration_number', $registrationNumber)
            ->orderBy('class_members.enrollment_date', 'DESC')
            ->findAll();
    }
    
    public function enrollStudents($classId, array $registrationNumbers, $enrollmentDate = null)
    {
        $enrollmentDate = $enrollmentDate ?? date('Y-m-d');
        $enrolled = [];
        $errors = [];
        
        foreach ($registrationNumbers as $regNumber) {
            if ($this->isEnrolled($classId, $regNumber)) {
                $errors[] = "Student {$regNumber} is already enrolled";
                continue;
            }
            
            $data = [
                'class_id' => $classId,
                'registration_number' => $regNumber,
                'enrollment_date' => $enrollmentDate,
                'status' => 'active'
            ];
            
            if ($this->insert($data)) {
                $enrolled[] = $regNumber;
            } else {
                $errors[] = "Failed to enroll {$regNumber}";
            }
        }
        
        return [
            'enrolled' => $enrolled,
            'errors' => $errors,
            'count' => count($enrolled)
        ];
    }
}
```

---

## 4. Controller Implementation

### 4.1 ClassController

**File**: `app/Modules/Academic/Controllers/ClassController.php`

Key methods:
- `index()` - List all classes with stats
- `create()` - Show create form
- `store()` - Save new class
- `view($id)` - Show class details with members
- `edit($id)` - Show edit form
- `update($id)` - Update class
- `delete($id)` - Soft delete class
- `assignStudents($id)` - Show assignment interface
- `enrollStudents($id)` - Process enrollment

### 4.2 ClassMemberController

**File**: `app/Modules/Academic/Controllers/ClassMemberController.php`

Key methods:
- `index()` - List all enrollments
- `view($id)` - Show member details
- `updateStatus($id)` - Update member status
- `remove($id)` - Remove member from class
- `export($classId)` - Export class roster

---

## 5. View Design

### 5.1 Class List View

**File**: `app/Modules/Academic/Views/classes/index.php`

Features:
- Search bar
- Filter dropdowns (status, category, level)
- Table/card layout
- Status badges with colors
- Enrollment stats (5/20)
- Action buttons (View, Edit, Delete, Assign)
- Pagination

### 5.2 Class Detail View

**File**: `app/Modules/Academic/Views/classes/view.php`

Sections:
- Class information card
- Statistics cards (total enrolled, capacity, etc.)
- Members table with actions
- Action buttons (Edit, Assign Students, Export, Delete)

### 5.3 Student Assignment View

**File**: `app/Modules/Academic/Views/classes/assign_students.php`

Features:
- List of approved applicants
- Checkbox selection
- Search and filter
- Show already enrolled students (disabled)
- Capacity indicator
- Bulk enroll button

---

## 6. Business Logic

### 6.1 Enrollment Process

```php
// Pseudo-code for enrollment
function enrollStudents($classId, $studentIds) {
    // 1. Check class exists
    $class = ClassModel->find($classId);
    if (!$class) return error;
    
    // 2. Check capacity
    if (!ClassModel->hasCapacity($classId)) {
        return error('Class is full');
    }
    
    // 3. Validate students are approved
    foreach ($studentIds as $studentId) {
        $admission = AdmissionModel->find($studentId);
        if ($admission['status'] !== 'approved') {
            skip or error;
        }
    }
    
    // 4. Check for duplicates
    foreach ($studentIds as $studentId) {
        if (ClassMemberModel->isEnrolled($classId, $studentId)) {
            skip or error;
        }
    }
    
    // 5. Enroll students
    $result = ClassMemberModel->enrollStudents($classId, $studentIds);
    
    return $result;
}
```

### 6.2 Status Badge Helper

```php
function getStatusBadge($status) {
    $badges = [
        'draft' => '<span class="badge bg-secondary">Draft</span>',
        'active' => '<span class="badge bg-primary">Active</span>',
        'ongoing' => '<span class="badge bg-success">Ongoing</span>',
        'completed' => '<span class="badge bg-dark">Completed</span>',
        'cancelled' => '<span class="badge bg-danger">Cancelled</span>'
    ];
    return $badges[$status] ?? $status;
}
```

---

## 7. Integration Points

### 7.1 Admission Module Integration

```php
// Get approved applicants for assignment
$admissionModel = new \Modules\Admission\Models\AdmissionModel();
$approvedApplicants = $admissionModel->where('status', 'approved')->findAll();
```

### 7.2 Dashboard Integration

Add academic statistics widget to dashboard:
- Total classes
- Active classes
- Total enrolled students
- Recent enrollments

---

## 8. Security Considerations

1. **Authentication**: All routes protected by session filter
2. **Authorization**: Check user permissions before actions
3. **Input Validation**: All inputs validated at model level
4. **SQL Injection**: Use query builder, never raw SQL
5. **CSRF Protection**: All forms include CSRF token
6. **XSS Prevention**: Escape all output with `esc()`

---

## 9. Performance Optimization

1. **Indexes**: Added on frequently queried columns
2. **Eager Loading**: Join tables to reduce queries
3. **Pagination**: Limit results per page
4. **Caching**: Cache class statistics (optional)
5. **Soft Deletes**: Use indexes on deleted_at

---

## 10. Testing Strategy

### Unit Tests
- Model validation rules
- UUID generation
- Date validation
- Capacity checking
- Duplicate enrollment prevention

### Integration Tests
- Complete enrollment workflow
- Class CRUD operations
- Member management
- Search and filter

### UI Tests
- Form validation
- Status badge display
- Pagination
- Export functionality

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-03  
**Status**: ✅ Ready for Implementation
