# Roles and Permissions Structure

## Overview
The system now supports multiple admin types with specific access controls. Users can have multiple roles simultaneously.

## Available Roles

### 1. Superadmin
- **Description**: Complete control of the site
- **Permissions**: All permissions (admin.*, users.*, beta.*, dashboard.*, admission.*, program.*, payment.*, invoice.*)
- **Access**: Everything

### 2. Admin
- **Description**: Day to day administrators
- **Permissions**: 
  - admin.access
  - users.create, users.edit, users.delete
  - beta.access
  - dashboard.access
  - admission.manage
  - program.manage
  - payment.manage
  - invoice.manage
- **Access**: Full CRUD on all modules except user management

### 3. Frontline Admin ⭐ NEW
- **Description**: Manages admissions and programs
- **Permissions**:
  - dashboard.access
  - admission.manage
  - program.manage
- **Access**: 
  - ✅ Dashboard
  - ✅ Admissions (full CRUD)
  - ✅ Programs (full CRUD)
  - ❌ Payments
  - ❌ Invoices
  - ❌ User Management

### 4. Finance Admin ⭐ NEW
- **Description**: Manages payments and invoices
- **Permissions**:
  - dashboard.access
  - payment.manage
  - invoice.manage
- **Access**:
  - ✅ Dashboard
  - ✅ Payments (full CRUD)
  - ✅ Invoices (full CRUD)
  - ✅ Financial Reports
  - ❌ Admissions
  - ❌ Programs
  - ❌ User Management

### 5. Staff
- **Description**: Read-only access to most modules
- **Permissions**:
  - dashboard.access
  - admission.view
  - program.view
  - payment.view
  - invoice.view
- **Access**: View-only access to all modules

### 6. Instructor
- **Description**: Teaching staff
- **Permissions**:
  - dashboard.access
  - admission.view
  - program.view
- **Access**: View-only access to admissions and programs

### 7. Student (Default)
- **Description**: General users
- **Permissions**: None
- **Access**: Basic authenticated user access only

## Multi-Role Support

### Example Scenarios:

#### Scenario 1: User with both Frontline and Finance roles
```php
$user->addGroup('frontline');
$user->addGroup('finance');
```
**Result**: User can access:
- ✅ Dashboard
- ✅ Admissions (full CRUD)
- ✅ Programs (full CRUD)
- ✅ Payments (full CRUD)
- ✅ Invoices (full CRUD)
- ✅ Financial Reports

#### Scenario 2: User with Frontline role only
```php
$user->addGroup('frontline');
```
**Result**: User can access:
- ✅ Dashboard
- ✅ Admissions (full CRUD)
- ✅ Programs (full CRUD)
- ❌ Payments (not visible in menu)
- ❌ Invoices (not visible in menu)

#### Scenario 3: User with Finance role only
```php
$user->addGroup('finance');
```
**Result**: User can access:
- ✅ Dashboard
- ✅ Payments (full CRUD)
- ✅ Invoices (full CRUD)
- ✅ Financial Reports
- ❌ Admissions (not visible in menu)
- ❌ Programs (not visible in menu)

## Permission Types

### Manage Permissions (Full CRUD)
- `admission.manage` - Create, Read, Update, Delete admissions
- `program.manage` - Create, Read, Update, Delete programs
- `payment.manage` - Create, Read, Update, Delete payments
- `invoice.manage` - Create, Read, Update, Delete invoices

### View Permissions (Read-only)
- `admission.view` - View admissions only
- `program.view` - View programs only
- `payment.view` - View payments only
- `invoice.view` - View invoices only

### Admin Permissions
- `admin.access` - Access admin area
- `admin.settings` - Modify system settings
- `users.edit` - Manage user roles
- `users.create` - Create new users
- `users.delete` - Delete users

## How to Assign Roles

### Via User Management UI:
1. Navigate to **User Management** (requires `users.edit` permission)
2. Click **Edit Roles** for a user
3. Check one or more role checkboxes
4. Click **Update Roles**

### Via Code:
```php
$user = auth()->user();

// Add single role
$user->addGroup('frontline');

// Add multiple roles
$user->addGroup('frontline');
$user->addGroup('finance');

// Remove role
$user->removeGroup('frontline');

// Check if user has role
if ($user->inGroup('finance')) {
    // User is in finance group
}

// Check if user has permission
if ($user->can('payment.manage')) {
    // User can manage payments
}
```

## Menu Visibility

Menus automatically show/hide based on user permissions:

- **Admissions Menu**: Visible if user has `admission.manage` OR `admission.view`
- **Programs Menu**: Visible if user has `program.manage` OR `program.view`
- **Payments Menu**: Visible if user has `payment.manage`
- **Invoices Menu**: Visible if user has `invoice.manage`
- **Reports Menu**: Visible if user has `payment.manage` OR `invoice.manage`
- **User Management Menu**: Visible if user has `users.edit`
- **My Profile Menu**: Visible to all authenticated users

## Best Practices

1. **Principle of Least Privilege**: Assign only the roles users need
2. **Multi-Role for Flexibility**: Combine roles when users need access to multiple areas
3. **Regular Audits**: Review user roles periodically
4. **Superadmin Sparingly**: Only assign to system owners
5. **Test Access**: After assigning roles, verify the user can access what they need

## Default Role

New users are automatically assigned the **student** role upon registration (configured in `AuthGroups.php`).
