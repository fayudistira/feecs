# Users Module Setup Complete

## Overview
The Users module provides administrative functionality to manage all system users, their roles, and account status.

## Module Structure
```
app/Modules/Users/
├── Config/
│   ├── Menu.php          # Menu configuration
│   └── Routes.php        # Module routes
├── Controllers/
│   └── UserController.php
└── Views/
    ├── index.php         # User list
    └── edit.php          # Edit user roles
```

## Features

### 1. User List (`/users`)
- View all users in the system
- Display user information:
  - ID, Username, Email
  - Assigned roles (with badges)
  - Account status (Active/Inactive)
  - Last active timestamp
- Quick actions:
  - Edit roles
  - Activate/Deactivate account

### 2. Edit User Roles (`/users/edit/{id}`)
- View user details in sidebar
- Assign/remove roles with checkboxes
- Each role card shows:
  - Role title and description
  - Associated permissions
  - Current status badge
- Visual feedback for current roles

### 3. Toggle User Status (`/users/toggle-status/{id}`)
- Activate inactive users
- Deactivate active users
- Confirmation prompt before action

## Available Roles (from AuthGroups.php)

### Superadmin
- **Title**: Super Admin
- **Description**: Complete control of the site
- **Permissions**: All permissions (admin.*, users.*, beta.*, dashboard.*, admission.*, program.*)

### Admin
- **Title**: Admin
- **Description**: Day to day administrators of the site
- **Permissions**: admin.access, users.create/edit/delete, beta.access, dashboard.access, admission.manage, program.manage

### Instructor
- **Title**: Instructor
- **Description**: Site instructors
- **Permissions**: dashboard.access, admission.view, program.view

### Staff
- **Title**: Staff
- **Description**: Staff members
- **Permissions**: dashboard.access, admission.view, program.view

### Student (Default)
- **Title**: Student
- **Description**: General users of the site
- **Permissions**: None (basic access only)

## Routes

| Method | Route | Action | Permission Required |
|--------|-------|--------|-------------------|
| GET | /users | List all users | users.edit |
| GET | /users/edit/{id} | Edit user roles | users.edit |
| POST | /users/update/{id} | Update user roles | users.edit |
| GET | /users/toggle-status/{id} | Toggle active status | users.edit |

## Access Control

- **Menu Item**: Only visible to users with `users.edit` permission
- **Routes**: Protected by `session` filter (authentication required)
- **Permission Check**: Users without `users.edit` permission cannot access the module

## How to Use

### As an Administrator:

1. **View All Users**
   - Navigate to "User Management" in the sidebar
   - See list of all registered users

2. **Assign Roles**
   - Click "Edit Roles" button for a user
   - Check/uncheck role checkboxes
   - Click "Update Roles" to save

3. **Manage Account Status**
   - Click "Activate" or "Deactivate" button
   - Confirm the action
   - User status updates immediately

### Role Assignment Best Practices:

- **Superadmin**: Only for system owners (use sparingly)
- **Admin**: For trusted administrators who manage the system
- **Instructor**: For teaching staff who need to view student data
- **Staff**: For administrative staff with limited access
- **Student**: Default role for regular users

## Database Tables Used

- **users**: Main user table (from Shield)
- **auth_groups_users**: Stores user-role relationships
- **auth_identities**: Stores email addresses and passwords

## Security Features

1. **Permission-based access**: Only users with `users.edit` can access
2. **CSRF protection**: All forms include CSRF tokens
3. **Confirmation prompts**: Status changes require confirmation
4. **Audit trail**: Shield tracks login attempts and user activity

## Integration with Account Module

- **Account Module**: Users manage their own profile (name, address, photo)
- **Users Module**: Admins manage user roles and system access
- Both modules work together for complete user management

## Next Steps (Optional Enhancements)

- Add user creation form
- Add user deletion with confirmation
- Add bulk role assignment
- Add user search and filtering
- Add activity log viewer
- Add password reset functionality
- Export user list to CSV
