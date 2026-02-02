# Academic Module - Implementation Plan

## Overview
Create an Academic module that allows administrators to manage classes and assign approved applicants to those classes. This module will handle class management, student enrollment, and class membership tracking.

## Core Entities

### 1. Class Entity
**Table**: `classes`

**Fields**:
- `id` (UUID, Primary Key)
- `class_name` (VARCHAR 100, Required) - e.g., "Web Development Batch 5"
- `class_category` (VARCHAR 100, Required) - e.g., "Programming", "Design", "Business"
- `class_level` (ENUM: beginner, intermediate, advanced, Required)
- `class_batch` (VARCHAR 50, Required) - e.g., "2026-A", "Batch 5"
- `status` (ENUM: draft, active, ongoing, completed, cancelled, Required)
- `start_date` (DATE, Required)
- `end_date` (DATE, Required)
- `max_students` (INT, Optional) - Maximum capacity
- `description` (TEXT, Optional)
- `instructor_name` (VARCHAR 100, Optional)
- `created_at` (DATETIME)
- `updated_at` (DATETIME)
- `deleted_at` (DATETIME, Soft Delete)

### 2. Class Members Entity
**Table**: `class_members`

**Fields**:
- `id` (INT, Primary Key, Auto Increment)
- `class_id` (UUID, Foreign Key → classes.id)
- `registration_number` (VARCHAR 20, Foreign Key → admissions.registration_number)
- `enrollment_date` (DATE, Required)
- `status` (ENUM: active, dropped, completed, suspended, Required)
- `notes` (TEXT, Optional)
- `created_at` (DATETIME)
- `updated_at` (DATETIME)
- `deleted_at` (DATETIME, Soft Delete)

**Constraints**:
- Unique constraint on (class_id, registration_number) - Student can't be enrolled twice in same class
- Foreign key to classes table
- Foreign key to admissions table

## Module Structure

```
app/Modules/Academic/
├── Config/
│   ├── Routes.php
│   └── Menu.php
├── Controllers/
│   ├── ClassController.php
│   └── ClassMemberController.php
├── Models/
│   ├── ClassModel.php
│   └── ClassMemberModel.php
└── Views/
    ├── classes/
    │   ├── index.php (list all classes)
    │   ├── create.php (create new class)
    │   ├── edit.php (edit class)
    │   ├── view.php (view class details + members)
    │   └── assign_students.php (assign students to class)
    └── members/
        ├── index.php (list all enrollments)
        └── view.php (view member details)
```

## Key Features

### 1. Class Management
- ✅ Create new class with all details
- ✅ Edit class information
- ✅ View class details with member list
- ✅ Delete class (soft delete)
- ✅ Search and filter classes (by status, category, level, batch)
- ✅ View class statistics (total students, capacity, etc.)

### 2. Student Assignment
- ✅ View list of approved applicants (status = 'approved')
- ✅ Assign multiple students to a class at once
- ✅ Check class capacity before assignment
- ✅ Prevent duplicate enrollment
- ✅ Set enrollment date
- ✅ Add notes for enrollment

### 3. Class Members Management
- ✅ View all members in a class
- ✅ Remove student from class
- ✅ Update member status (active, dropped, completed, suspended)
- ✅ View member enrollment history
- ✅ Export class roster

## User Workflows

### Workflow 1: Create Class and Assign Students
1. Admin navigates to Academic module
2. Clicks "Create New Class"
3. Fills in class details (name, category, level, batch, dates, etc.)
4. Saves class
5. Clicks "Assign Students" on class detail page
6. Sees list of approved applicants
7. Selects students to enroll
8. Confirms enrollment
9. Students are added to class members list

### Workflow 2: Manage Class Members
1. Admin views class details
2. Sees list of enrolled students
3. Can update member status
4. Can remove students from class
5. Can add notes to enrollment

### Workflow 3: View Academic Statistics
1. Admin views classes list
2. Sees statistics: total classes, active classes, total students
3. Filters by status, category, or level
4. Views individual class capacity and enrollment

## Database Relationships

```
admissions (existing)
    ↓ (1:N)
class_members
    ↓ (N:1)
classes

- One admission can have many class_members (student can enroll in multiple classes)
- One class can have many class_members (class has multiple students)
- class_members is a junction/pivot table with additional fields
```

## Validation Rules

### Class Validation
- class_name: required, min 3 chars, max 100 chars
- class_category: required, min 3 chars
- class_level: required, in_list[beginner, intermediate, advanced]
- class_batch: required, min 2 chars
- status: required, in_list[draft, active, ongoing, completed, cancelled]
- start_date: required, valid_date
- end_date: required, valid_date, after start_date
- max_students: optional, integer, greater than 0

### Class Member Validation
- class_id: required, exists in classes table
- registration_number: required, exists in admissions table, status = 'approved'
- enrollment_date: required, valid_date
- status: required, in_list[active, dropped, completed, suspended]
- Unique constraint: student can't be enrolled twice in same class

## Business Rules

1. **Only approved applicants** can be assigned to classes
2. **Class capacity** must be checked before enrollment (if max_students is set)
3. **No duplicate enrollment** - student can't be in same class twice
4. **Date validation** - end_date must be after start_date
5. **Status transitions** - class status should follow logical flow (draft → active → ongoing → completed)
6. **Soft delete** - classes and members use soft delete for data retention

## Permissions

- `academic.manage` - Full access to academic module
- `academic.view` - View-only access
- `academic.assign` - Can assign students to classes
- `academic.edit` - Can edit classes and members

## UI/UX Considerations

### Class List View
- Card or table layout
- Color-coded status badges
- Quick stats (enrolled/capacity)
- Search and filter options
- Bulk actions support

### Class Detail View
- Class information card
- Members list with status
- Quick actions (assign students, edit, delete)
- Statistics (total enrolled, capacity, completion rate)

### Student Assignment View
- List of approved applicants
- Checkbox selection
- Search and filter applicants
- Show current enrollments
- Capacity warning

## Integration Points

### Existing Modules
1. **Admission Module**
   - Read approved applicants
   - Link to admission details
   - Show student information

2. **Dashboard Module**
   - Add academic statistics
   - Show active classes count
   - Show total enrolled students

3. **Program Module** (Optional)
   - Link classes to programs
   - Filter students by program

## API Endpoints (Optional)

```
GET    /api/classes              - List all classes
GET    /api/classes/{id}         - Get class details
POST   /api/classes              - Create class
PUT    /api/classes/{id}         - Update class
DELETE /api/classes/{id}         - Delete class
GET    /api/classes/{id}/members - Get class members
POST   /api/classes/{id}/assign  - Assign students to class
DELETE /api/classes/{id}/members/{memberId} - Remove student
```

## Migration Strategy

### Phase 1: Core Setup
1. Create module structure
2. Create migrations (classes, class_members)
3. Create models with validation
4. Set up routes and menu

### Phase 2: Class Management
1. Create class CRUD operations
2. Implement search and filter
3. Add validation and business rules

### Phase 3: Student Assignment
1. Create assignment interface
2. Implement enrollment logic
3. Add capacity checking
4. Prevent duplicate enrollment

### Phase 4: Member Management
1. Create member views
2. Implement status updates
3. Add removal functionality
4. Create export features

### Phase 5: Integration & Polish
1. Integrate with dashboard
2. Add statistics
3. Improve UI/UX
4. Add bulk operations

## Testing Checklist

- [ ] Create class with valid data
- [ ] Validate required fields
- [ ] Validate date ranges
- [ ] Assign approved student to class
- [ ] Prevent duplicate enrollment
- [ ] Check capacity limits
- [ ] Update member status
- [ ] Remove student from class
- [ ] Soft delete class
- [ ] Search and filter classes
- [ ] View class statistics
- [ ] Export class roster

## Future Enhancements

- Attendance tracking
- Grade management
- Class schedule/timetable
- Automatic class completion
- Email notifications for enrollment
- Student portal to view their classes
- Class materials/resources
- Assignment/homework management
- Certificate generation upon completion

## Estimated Complexity

- **Database**: Medium (2 tables with relationships)
- **Backend**: Medium (CRUD + assignment logic)
- **Frontend**: Medium (multiple views with interactions)
- **Integration**: Low (mainly reads from Admission module)

**Total Estimated Time**: 8-12 hours for full implementation

## Next Steps

1. Review and approve this plan
2. Create detailed requirements document
3. Create design document with code examples
4. Create task list for implementation
5. Begin implementation phase

---

**Status**: 📋 Planning Phase - Awaiting Review
