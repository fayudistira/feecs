# Test Accounts

## Admin Test Accounts Created

### 1. Frontline Admin
- **Email**: `frontline@example.com`
- **Password**: `frontline123`
- **Role**: Frontline Admin
- **Access**:
  - ✅ Dashboard
  - ✅ Admissions (full CRUD)
  - ✅ Programs (full CRUD)
  - ❌ Payments
  - ❌ Invoices
  - ❌ User Management

### 2. Finance Admin
- **Email**: `finance@example.com`
- **Password**: `finance123`
- **Role**: Finance Admin
- **Access**:
  - ✅ Dashboard
  - ✅ Payments (full CRUD)
  - ✅ Invoices (full CRUD)
  - ✅ Financial Reports
  - ❌ Admissions
  - ❌ Programs
  - ❌ User Management

### 3. Combined Admin (Both Roles)
- **Email**: `combined@example.com`
- **Password**: `combined123`
- **Roles**: Frontline Admin + Finance Admin
- **Access**:
  - ✅ Dashboard
  - ✅ Admissions (full CRUD)
  - ✅ Programs (full CRUD)
  - ✅ Payments (full CRUD)
  - ✅ Invoices (full CRUD)
  - ✅ Financial Reports
  - ❌ User Management

### 4. Existing Superadmin
- **Email**: `fayudistiraasna@gmail.com` (or check your database)
- **Username**: `administrator`
- **Role**: Superadmin
- **Access**: Everything (full system control)

## How to Test

### Test Frontline Admin:
1. Logout from current account
2. Login with: `frontline@example.com` / `frontline123`
3. Verify you can see:
   - Dashboard
   - Admissions menu
   - Programs menu
4. Verify you CANNOT see:
   - Payments menu
   - Invoices menu
   - User Management menu

### Test Finance Admin:
1. Logout from current account
2. Login with: `finance@example.com` / `finance123`
3. Verify you can see:
   - Dashboard
   - Payments menu
   - Invoices menu
   - Reports menu
4. Verify you CANNOT see:
   - Admissions menu
   - Programs menu
   - User Management menu

### Test Combined Admin:
1. Logout from current account
2. Login with: `combined@example.com` / `combined123`
3. Verify you can see:
   - Dashboard
   - Admissions menu
   - Programs menu
   - Payments menu
   - Invoices menu
   - Reports menu
4. Verify you CANNOT see:
   - User Management menu (requires users.edit permission)

## Re-running the Seeder

If you need to recreate these accounts:

```bash
php spark db:seed AdminUsersSeeder
```

**Note**: This will create duplicate accounts if run multiple times. To avoid duplicates, delete existing test accounts first or modify the seeder to check for existing users.

## Database Verification

Check users table:
```bash
php spark db:table users
```

Check role assignments:
```bash
php spark db:table auth_groups_users
```

## Security Note

⚠️ **Important**: These are test accounts with simple passwords. 
- Do NOT use these accounts in production
- Change passwords before deploying to production
- Delete or disable test accounts in production environment
