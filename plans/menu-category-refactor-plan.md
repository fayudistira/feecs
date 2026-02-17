# Menu Category Refactoring Plan

## Overview

Refactor the dashboard sidebar menu to organize items under collapsible categories instead of a flat list. This will improve navigation and user experience.

## Current Menu Structure

| Order | Title             | Permission       | Module    |
| ----- | ----------------- | ---------------- | --------- |
| 1     | Dashboard         | dashboard.access | Dashboard |
| 2     | My Class          | student.access   | Dashboard |
| 3     | My Invoices       | student.access   | Dashboard |
| 4     | My Payments       | student.access   | Dashboard |
| 4     | Manajemen Siswa   | student.manage   | Student   |
| 10    | Data Pendaftaran  | admission.manage | Admission |
| 15    | Data Kelas        | classroom.manage | Classroom |
| 19    | Contracts         | payment.manage   | Payment   |
| 20    | Master Program    | program.view     | Program   |
| 20    | Dormitory         | dormitory.view   | Dormitory |
| 20    | Pembayaran        | payment.manage   | Payment   |
| 21    | Invoices          | invoice.manage   | Payment   |
| 22    | Reports           | payment.manage   | Payment   |
| 50    | Manajemen Pegawai | admin.settings   | Employee  |
| 90    | Manajemen User    | admin.settings   | Users     |
| 100   | Settings          | admin.settings   | Settings  |

## Proposed Category Structure

```
Sidebar
├── Dashboard (standalone)
├── Student Portal (collapsible)
│   ├── My Class
│   ├── My Invoices
│   └── My Payments
├── Akademik (collapsible)
│   ├── Manajemen Siswa
│   ├── Data Pendaftaran
│   ├── Data Kelas
│   ├── Master Program
│   └── Dormitory
├── Keuangan (collapsible)
│   ├── Contracts
│   ├── Pembayaran
│   ├── Invoices
│   └── Reports
└── Administrasi (collapsible)
    ├── Manajemen Pegawai
    ├── Manajemen User
    └── Settings
```

## Technical Implementation

### 1. New Menu Configuration Format

Each module's Menu.php will add a `category` field:

```php
// Example: app/Modules/Student/Config/Menu.php
return [
    [
        'title' => 'Manajemen Siswa',
        'icon'  => 'mortarboard',
        'url'   => 'student',
        'order' => 4,
        'permission' => 'student.manage',
        'category' => 'academic'  // NEW: category assignment
    ]
];
```

### 2. Central Categories Configuration

Create `app/Config/MenuCategories.php`:

```php
return [
    'dashboard' => [
        'title' => 'Dashboard',
        'icon' => 'speedometer2',
        'order' => 1,
        'standalone' => true  // No collapsible, direct link
    ],
    'student_portal' => [
        'title' => 'Student Portal',
        'icon' => 'person-badge',
        'order' => 2,
        'permission' => 'student.access'
    ],
    'academic' => [
        'title' => 'Akademik',
        'icon' => 'book',
        'order' => 10,
        'permission' => ['student.manage', 'admission.manage', 'classroom.manage', 'program.view', 'dormitory.view']
    ],
    'finance' => [
        'title' => 'Keuangan',
        'icon' => 'cash-stack',
        'order' => 20,
        'permission' => ['payment.manage', 'invoice.manage']
    ],
    'administration' => [
        'title' => 'Administrasi',
        'icon' => 'gear',
        'order' => 30,
        'permission' => 'admin.settings'
    ]
];
```

### 3. Updated Menu Helper

The `render_menu()` function will be updated to:

1. Load categories from `MenuCategories.php`
2. Group menu items by category
3. Render collapsible sections for each category
4. Handle standalone items without categories
5. Check category-level permissions

### 4. CSS Additions

Add styles for collapsible category headers:

```css
.menu-category {
  margin-bottom: 0.5rem;
}

.menu-category-header {
  padding: 0.75rem 1rem;
  color: rgba(255, 255, 255, 0.6);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  cursor: pointer;
  transition: all 0.2s;
}

.menu-category-header:hover {
  color: rgba(255, 255, 255, 0.9);
}

.menu-category-header i {
  margin-right: 0.5rem;
  transition: transform 0.2s;
}

.menu-category.collapsed .menu-category-header i {
  transform: rotate(-90deg);
}

.menu-category-items {
  overflow: hidden;
  transition: max-height 0.3s ease;
}

.menu-category.collapsed .menu-category-items {
  max-height: 0;
}
```

### 5. JavaScript for Collapse

```javascript
document.querySelectorAll(".menu-category-header").forEach((header) => {
  header.addEventListener("click", () => {
    const category = header.closest(".menu-category");
    category.classList.toggle("collapsed");
    localStorage.setItem(
      `menu_category_${category.dataset.category}`,
      category.classList.contains("collapsed"),
    );
  });
});

// Restore collapsed state on load
document.querySelectorAll(".menu-category").forEach((category) => {
  const isCollapsed = localStorage.getItem(
    `menu_category_${category.dataset.category}`,
  );
  if (isCollapsed === "true") {
    category.classList.add("collapsed");
  }
});
```

## Files to Modify

| File                                            | Changes                        |
| ----------------------------------------------- | ------------------------------ |
| `app/Config/MenuCategories.php`                 | NEW - Define menu categories   |
| `app/Modules/Dashboard/Config/Menu.php`         | Add category field to items    |
| `app/Modules/Student/Config/Menu.php`           | Add category: academic         |
| `app/Modules/Admission/Config/Menu.php`         | Add category: academic         |
| `app/Modules/Classroom/Config/Menu.php`         | Add category: academic         |
| `app/Modules/Program/Config/Menu.php`           | Add category: academic         |
| `app/Modules/Dormitory/Config/Menu.php`         | Add category: academic         |
| `app/Modules/Payment/Config/Menu.php`           | Add category: finance          |
| `app/Modules/Employee/Config/Menu.php`          | Add category: administration   |
| `app/Modules/Users/Config/Menu.php`             | Add category: administration   |
| `app/Modules/Settings/Config/Menu.php`          | Add category: administration   |
| `app/Modules/Dashboard/Helpers/menu_helper.php` | Rewrite to support categories  |
| `app/Modules/Dashboard/Views/layout.php`        | Add CSS and JS for collapsible |

## Menu Item Category Assignments

| Module    | Title             | Category               |
| --------- | ----------------- | ---------------------- |
| Dashboard | Dashboard         | dashboard (standalone) |
| Dashboard | My Class          | student_portal         |
| Dashboard | My Invoices       | student_portal         |
| Dashboard | My Payments       | student_portal         |
| Student   | Manajemen Siswa   | academic               |
| Admission | Data Pendaftaran  | academic               |
| Classroom | Data Kelas        | academic               |
| Program   | Master Program    | academic               |
| Dormitory | Dormitory         | academic               |
| Payment   | Contracts         | finance                |
| Payment   | Pembayaran        | finance                |
| Payment   | Invoices          | finance                |
| Payment   | Reports           | finance                |
| Employee  | Manajemen Pegawai | administration         |
| Users     | Manajemen User    | administration         |
| Settings  | Settings          | administration         |

## Visual Mockup

```
┌─────────────────────┐
│  ◉ SOSCT       [◀]  │
├─────────────────────┤
│                     │
│  ◉ Dashboard        │  ← Standalone
│                     │
│  ▼ Student Portal   │  ← Category Header (collapsible)
│    ○ My Class       │
│    ○ My Invoices    │
│    ○ My Payments    │
│                     │
│  ▼ Akademik         │
│    ○ Manajemen Siswa│
│    ○ Data Pendaftaran│
│    ○ Data Kelas     │
│    ○ Master Program │
│    ○ Dormitory      │
│                     │
│  ▼ Keuangan         │
│    ○ Contracts      │
│    ○ Pembayaran     │
│    ○ Invoices       │
│    ○ Reports        │
│                     │
│  ▼ Administrasi     │
│    ○ Manajemen Pegawai│
│    ○ Manajemen User │
│    ○ Settings       │
│                     │
├─────────────────────┤
│  👤 User Name       │
└─────────────────────┘
```

## Implementation Steps

1. Create `app/Config/MenuCategories.php` with category definitions
2. Update all module `Config/Menu.php` files to add `category` field
3. Rewrite `app/Modules/Dashboard/Helpers/menu_helper.php` to:
   - Load categories
   - Group items by category
   - Render collapsible sections
4. Update `app/Modules/Dashboard/Views/layout.php` to add CSS and JS
5. Test with different user roles to verify permission-based visibility

## Backward Compatibility

- Menu items without a `category` field will appear at the top level
- If `MenuCategories.php` doesn't exist, fall back to flat menu
- Existing submenu functionality will be preserved within categories
