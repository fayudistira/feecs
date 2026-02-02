# Academic Module - Requirements Specification

## 1. Overview

### 1.1 Purpose
The Academic Module enables administrators to manage classes and assign approved applicants to those classes, creating a structured academic environment for tracking student enrollments and class management.

### 1.2 Scope
- Class creation and management
- Student assignment to classes
- Class membership tracking
- Enrollment status management
- Academic statistics and reporting

### 1.3 Stakeholders
- **Administrators**: Manage classes and assign students
- **Academic Staff**: View class information and rosters
- **Students**: (Future) View their enrolled classes

---

## 2. Functional Requirements

### 2.1 Class Management

#### FR-1: Create Class
**Priority**: High  
**User Story**: As an administrator, I want to create a new class with all necessary details so that I can organize students into structured learning groups.

**Acceptance Criteria**:
- Admin can access "Create Class" form
- Form includes all required fields:
  - Class Name (required, 3-100 chars)
  - Class Category (required, 3-100 chars)
  - Class Level (required, dropdown: beginner/intermediate/advanced)
  - Class Batch (required, 2-50 chars)
  - Status (required, dropdown: draft/active/ongoing/completed/cancelled)
  - Start Date (required, date picker)
  - End Date (required, date picker, must be after start date)
  - Max Students (optional, integer > 0)
  - Description (optional, textarea)
  - Instructor Name (optional, 3-100 chars)
- Form validates all inputs before submission
- Success message displayed after creation
- Redirects to class detail page after creation
- UUID generated automatically for class ID

#### FR-2: View Class List
**Priority**: High  
**User Story**: As an administrator, I want to view a list of all classes so that I can manage and monitor them effectively.

**Acceptance Criteria**:
- Displays all classes in table or card layout
- Shows key information: name, category, level, batch, status, dates, enrolled/capacity
- Status displayed with color-coded badges:
  - Draft: Gray
  - Active: Blue
  - Ongoing: Green
  - Completed: Dark Green
  - Cancelled: Red
- Pagination (20 items per page)
- Search functionality (by name, category, batch)
- Filter options:
  - By status
  - By category
  - By level
  - By date range
- Sort options (by name, start date, status)
- Quick actions: View, Edit, Delete, Assign Students

#### FR-3: View Class Details
**Priority**: High  
**User Story**: As an administrator, I want to view detailed information about a class including its members so that I can monitor class composition and status.

**Acceptance Criteria**:
- Displays all class information
- Shows class statistics:
  - Total enrolled students
  - Capacity (if set)
  - Enrollment percentage
  - Active members count
  - Dropped members count
- Lists all class members with:
  - Student name
  - Registration number
  - Enrollment date
  - Status
  - Actions (update status, remove, view details)
- Action buttons:
  - Edit Class
  - Assign Students
  - Export Roster
  - Delete Class
- Breadcrumb navigation

#### FR-4: Edit Class
**Priority**: High  
**User Story**: As an administrator, I want to edit class information so that I can keep class details up-to-date.

**Acceptance Criteria**:
- Pre-fills form with existing class data
- All fields editable except ID
- Same validation as create form
- End date must be after start date
- Success message after update
- Redirects to class detail page
- Tracks update timestamp

#### FR-5: Delete Class
**Priority**: Medium  
**User Story**: As an administrator, I want to delete a class so that I can remove cancelled or obsolete classes.

**Acceptance Criteria**:
- Soft delete (sets deleted_at timestamp)
- Confirmation dialog before deletion
- Warning if class has enrolled students
- Option to remove all members before deletion
- Success message after deletion
- Redirects to class list
- Deleted classes not shown in default list
- Option to view deleted classes (admin only)

### 2.2 Student Assignment

#### FR-6: Assign Students to Class
**Priority**: High  
**User Story**: As an administrator, I want to assign approved applicants to a class so that students can begin their learning journey.

**Acceptance Criteria**:
- Displays list of approved applicants (admission status = 'approved')
- Shows applicant information:
  - Full name
  - Registration number
  - Email
  - Phone
  - Program (if applicable)
  - Current enrollments
- Checkbox selection for multiple students
- Search functionality
- Filter by program
- Shows capacity warning if class is full
- Prevents enrollment if capacity reached
- Sets enrollment date (defaults to today)
- Sets initial status as 'active'
- Validates no duplicate enrollment
- Success message with count of enrolled students
- Refreshes class member list

#### FR-7: Prevent Duplicate Enrollment
**Priority**: High  
**User Story**: As a system, I must prevent students from being enrolled in the same class twice to maintain data integrity.

**Acceptance Criteria**:
- Database unique constraint on (class_id, registration_number)
- UI shows already enrolled students as disabled/grayed out
- Error message if duplicate enrollment attempted
- Validation at both UI and backend levels

#### FR-8: Check Class Capacity
**Priority**: Medium  
**User Story**: As an administrator, I want the system to check class capacity before enrollment so that classes don't exceed their limits.

**Acceptance Criteria**:
- If max_students is set, check before enrollment
- Show capacity status: "5/20 enrolled" or "Full"
- Warning message if trying to exceed capacity
- Option to override capacity (admin only)
- Visual indicator (progress bar) for capacity

### 2.3 Class Member Management

#### FR-9: View Class Members
**Priority**: High  
**User Story**: As an administrator, I want to view all members of a class so that I can monitor enrollment and student status.

**Acceptance Criteria**:
- Displays all members in table format
- Shows:
  - Student name (linked to admission details)
  - Registration number
  - Enrollment date
  - Status (color-coded badge)
  - Notes
  - Actions
- Filter by status
- Search by name or registration number
- Sort by enrollment date, name, status
- Export to CSV/Excel

#### FR-10: Update Member Status
**Priority**: High  
**User Story**: As an administrator, I want to update a student's enrollment status so that I can track their progress and changes.

**Acceptance Criteria**:
- Status options:
  - Active (default)
  - Dropped (student left class)
  - Completed (finished class)
  - Suspended (temporarily inactive)
- Dropdown or modal for status change
- Optional notes field for reason
- Confirmation for status change
- Tracks update timestamp
- Success message
- Updates class statistics

#### FR-11: Remove Student from Class
**Priority**: Medium  
**User Story**: As an administrator, I want to remove a student from a class so that I can manage class composition.

**Acceptance Criteria**:
- Soft delete (sets deleted_at)
- Confirmation dialog
- Optional reason/notes
- Success message
- Updates class statistics
- Student can be re-enrolled later

#### FR-12: View Member Details
**Priority**: Low  
**User Story**: As an administrator, I want to view detailed information about a class member so that I can understand their enrollment history.

**Acceptance Criteria**:
- Shows all enrollment information
- Links to admission details
- Shows enrollment history (if multiple classes)
- Shows notes and status changes
- Option to edit notes

### 2.4 Statistics and Reporting

#### FR-13: View Academic Statistics
**Priority**: Medium  
**User Story**: As an administrator, I want to view academic statistics so that I can monitor overall academic performance.

**Acceptance Criteria**:
- Dashboard widget showing:
  - Total classes
  - Active classes
  - Total enrolled students
  - Classes by status (chart)
  - Recent enrollments
- Class list shows individual statistics
- Filterable by date range

#### FR-14: Export Class Roster
**Priority**: Medium  
**User Story**: As an administrator, I want to export a class roster so that I can share it with instructors or use it offline.

**Acceptance Criteria**:
- Export formats: CSV, Excel, PDF
- Includes all member information
- Includes class details header
- Formatted and printable
- Download button on class detail page

---

## 3. Non-Functional Requirements

### 3.1 Performance
- NFR-1: Class list page loads in < 2 seconds
- NFR-2: Student assignment handles up to 100 students at once
- NFR-3: Search results return in < 1 second

### 3.2 Security
- NFR-4: Only authenticated administrators can access module
- NFR-5: All inputs sanitized and validated
- NFR-6: SQL injection prevention
- NFR-7: CSRF protection on all forms

### 3.3 Usability
- NFR-8: Responsive design (mobile, tablet, desktop)
- NFR-9: Consistent UI with existing modules
- NFR-10: Clear error messages
- NFR-11: Confirmation dialogs for destructive actions

### 3.4 Reliability
- NFR-12: Soft delete for data retention
- NFR-13: Transaction support for enrollment
- NFR-14: Error logging for debugging

### 3.5 Maintainability
- NFR-15: Follow CodeIgniter 4 best practices
- NFR-16: Modular architecture
- NFR-17: Comprehensive code comments
- NFR-18: Consistent naming conventions

---

## 4. Data Requirements

### 4.1 Classes Table
```sql
CREATE TABLE classes (
    id CHAR(36) PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    class_category VARCHAR(100) NOT NULL,
    class_level ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    class_batch VARCHAR(50) NOT NULL,
    status ENUM('draft', 'active', 'ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'draft',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    max_students INT NULL,
    description TEXT NULL,
    instructor_name VARCHAR(100) NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    INDEX idx_status (status),
    INDEX idx_category (class_category),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_deleted (deleted_at)
);
```

### 4.2 Class Members Table
```sql
CREATE TABLE class_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id CHAR(36) NOT NULL,
    registration_number VARCHAR(20) NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('active', 'dropped', 'completed', 'suspended') NOT NULL DEFAULT 'active',
    notes TEXT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (registration_number) REFERENCES admissions(registration_number) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (class_id, registration_number, deleted_at),
    INDEX idx_class (class_id),
    INDEX idx_student (registration_number),
    INDEX idx_status (status),
    INDEX idx_deleted (deleted_at)
);
```

---

## 5. Business Rules

1. Only applicants with status = 'approved' can be assigned to classes
2. Class end_date must be after start_date
3. Student cannot be enrolled in same class twice (active enrollment)
4. If max_students is set, enrollment cannot exceed capacity
5. Soft delete preserves data for reporting
6. Status transitions should be logical (draft → active → ongoing → completed)
7. Removing a student sets deleted_at, doesn't delete record

---

## 6. Success Criteria

- ✅ Admin can create and manage classes
- ✅ Admin can assign approved students to classes
- ✅ System prevents duplicate enrollments
- ✅ System checks class capacity
- ✅ Admin can update member status
- ✅ Admin can view class statistics
- ✅ All data properly validated
- ✅ Responsive UI works on all devices
- ✅ Integration with existing modules works

---

## 7. Out of Scope (Future Enhancements)

- Attendance tracking
- Grade management
- Class schedule/timetable
- Student portal
- Email notifications
- Certificate generation
- Assignment management
- Class materials/resources

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-03  
**Status**: ✅ Ready for Design Phase
