# FEECS - Technical Documentation

## Project Overview

**FEECS** (Foreign Language Education and Course System) is a comprehensive language course management system built with CodeIgniter 4. The system manages language course programs, student admissions, payments, invoices, classrooms, messaging, and user management.

**Technology Stack:**

- **Backend Framework**: CodeIgniter 4 (PHP)
- **Database**: MySQL
- **Authentication**: CodeIgniter Shield
- **Frontend**: Bootstrap 5, JavaScript
- **Architecture**: Modular HMVC (Hierarchical Model-View-Controller)

---

## Module Structure

The application follows a modular architecture with 11 modules:

| Module    | Purpose                                              | Access Level               |
| --------- | ---------------------------------------------------- | -------------------------- |
| Frontend  | Public-facing pages, landing pages, program listings | Public                     |
| Account   | User profile management                              | Authenticated              |
| Admission | Student admission management                         | Staff/Admin                |
| Classroom | Classroom management                                 | Authenticated              |
| Dashboard | Main dashboard                                       | Authenticated              |
| Employee  | HR/Employee management                               | Admin/Superadmin/Frontline |
| Messaging | Internal messaging system                            | Authenticated              |
| Payment   | Payment and invoice management                       | Authenticated              |
| Program   | Course program management                            | Staff/Admin                |
| Settings  | System settings and utilities                        | Admin                      |
| Student   | Student management                                   | Staff/Admin                |
| Users     | User management                                      | Authenticated              |

---

## Database Schema

### Core Tables

#### 1. `programs`

Stores language course programs with pricing and features.

| Field            | Type          | Description                                                    |
| ---------------- | ------------- | -------------------------------------------------------------- |
| id               | VARCHAR(36)   | UUID primary key                                               |
| title            | VARCHAR(255)  | Program name                                                   |
| description      | TEXT          | Program description                                            |
| features         | JSON          | Array of program features                                      |
| facilities       | JSON          | Array of facilities                                            |
| extra_facilities | JSON          | Array of extra facilities                                      |
| registration_fee | DECIMAL(10,2) | Registration fee amount                                        |
| tuition_fee      | DECIMAL(10,2) | Tuition fee amount                                             |
| discount         | DECIMAL(5,2)  | Discount percentage (0-100)                                    |
| category         | VARCHAR(100)  | Language category (Chinese, Japanese, Korean, German, English) |
| sub_category     | VARCHAR(100)  | Subcategory (Regular, Package, Private)                        |
| mode             | VARCHAR(20)   | Delivery mode (online, offline)                                |
| curriculum       | JSON          | Curriculum data                                                |
| thumbnail        | VARCHAR(255)  | Thumbnail image filename                                       |
| status           | ENUM          | active/inactive                                                |
| created_at       | TIMESTAMP     | Creation timestamp                                             |
| updated_at       | TIMESTAMP     | Update timestamp                                               |
| deleted_at       | TIMESTAMP     | Soft delete timestamp                                          |

#### 2. `admissions`

Stores student admission applications.

| Field                      | Type         | Description                      |
| -------------------------- | ------------ | -------------------------------- |
| id                         | INT          | Auto-increment primary key       |
| registration_number        | VARCHAR(20)  | Unique registration number       |
| full_name                  | VARCHAR(100) | Student full name                |
| nickname                   | VARCHAR(50)  | Student nickname                 |
| gender                     | ENUM         | Male/Female                      |
| place_of_birth             | VARCHAR(100) | Birth place                      |
| date_of_birth              | DATE         | Birth date                       |
| religion                   | VARCHAR(50)  | Religion                         |
| citizen_id                 | VARCHAR(20)  | Citizen ID number                |
| phone                      | VARCHAR(15)  | Phone number                     |
| email                      | VARCHAR(100) | Email address (unique)           |
| street_address             | TEXT         | Street address                   |
| district                   | VARCHAR(100) | District                         |
| regency                    | VARCHAR(100) | Regency/City                     |
| province                   | VARCHAR(100) | Province                         |
| postal_code                | VARCHAR(10)  | Postal code                      |
| emergency_contact_name     | VARCHAR(100) | Emergency contact name           |
| emergency_contact_phone    | VARCHAR(15)  | Emergency contact phone          |
| emergency_contact_relation | VARCHAR(50)  | Emergency contact relation       |
| father_name                | VARCHAR(100) | Father's name                    |
| mother_name                | VARCHAR(100) | Mother's name                    |
| course                     | VARCHAR(100) | Selected course                  |
| status                     | ENUM         | pending/approved/rejected        |
| application_date           | DATE         | Application date                 |
| photo                      | VARCHAR(255) | Photo filename                   |
| documents                  | TEXT         | JSON array of document filenames |
| notes                      | TEXT         | Additional notes                 |
| created_at                 | DATETIME     | Creation timestamp               |
| updated_at                 | DATETIME     | Update timestamp                 |
| deleted_at                 | DATETIME     | Soft delete timestamp            |

#### 3. `invoices`

Stores billing invoices for students.

| Field               | Type          | Description                                    |
| ------------------- | ------------- | ---------------------------------------------- |
| id                  | INT           | Auto-increment primary key                     |
| invoice_number      | VARCHAR(50)   | Unique invoice number                          |
| registration_number | VARCHAR(20)   | FK to admissions.registration_number           |
| description         | TEXT          | Invoice description                            |
| items               | JSON          | Invoice items (JSON)                           |
| amount              | DECIMAL(10,2) | Invoice amount                                 |
| due_date            | DATE          | Payment due date                               |
| invoice_type        | ENUM          | registration_fee/tuition_fee/miscellaneous_fee |
| status              | ENUM          | unpaid/paid/cancelled/expired/partially_paid   |
| created_at          | DATETIME      | Creation timestamp                             |
| updated_at          | DATETIME      | Update timestamp                               |
| deleted_at          | DATETIME      | Soft delete timestamp                          |

#### 4. `payments`

Stores payment records.

| Field               | Type          | Description                          |
| ------------------- | ------------- | ------------------------------------ |
| id                  | INT           | Auto-increment primary key           |
| registration_number | VARCHAR(20)   | FK to admissions.registration_number |
| invoice_id          | INT           | FK to invoices.id                    |
| amount              | DECIMAL(10,2) | Payment amount                       |
| payment_method      | ENUM          | cash/bank_transfer                   |
| document_number     | VARCHAR(100)  | Payment document number              |
| payment_date        | DATE          | Payment date                         |
| receipt_file        | VARCHAR(255)  | Receipt image filename               |
| status              | ENUM          | pending/paid/failed/refunded         |
| failure_reason      | TEXT          | Failure reason                       |
| refund_date         | DATE          | Refund date                          |
| refund_reason       | TEXT          | Refund reason                        |
| notes               | TEXT          | Additional notes                     |
| created_at          | DATETIME      | Creation timestamp                   |
| updated_at          | DATETIME      | Update timestamp                     |
| deleted_at          | DATETIME      | Soft delete timestamp                |

#### 5. `students`

Stores enrolled students.

| Field               | Type        | Description                          |
| ------------------- | ----------- | ------------------------------------ |
| id                  | INT         | Auto-increment primary key           |
| registration_number | VARCHAR(20) | FK to admissions.registration_number |
| student_id          | VARCHAR(20) | Unique student ID                    |
| enrollment_date     | DATE        | Enrollment date                      |
| status              | ENUM        | active/inactive/graduated/suspended  |
| created_at          | DATETIME    | Creation timestamp                   |
| updated_at          | DATETIME    | Update timestamp                     |
| deleted_at          | DATETIME    | Soft delete timestamp                |

#### 6. `staff`

Stores staff/employee records.

| Field       | Type         | Description                |
| ----------- | ------------ | -------------------------- |
| id          | INT          | Auto-increment primary key |
| user_id     | INT          | FK to users.id             |
| employee_id | VARCHAR(20)  | Unique employee ID         |
| position    | VARCHAR(100) | Job position               |
| department  | VARCHAR(100) | Department                 |
| hire_date   | DATE         | Hire date                  |
| status      | ENUM         | active/inactive            |
| created_at  | DATETIME     | Creation timestamp         |
| updated_at  | DATETIME     | Update timestamp           |
| deleted_at  | DATETIME     | Soft delete timestamp      |

#### 7. `instructors`

Stores instructor records.

| Field          | Type         | Description                |
| -------------- | ------------ | -------------------------- |
| id             | INT          | Auto-increment primary key |
| user_id        | INT          | FK to users.id             |
| instructor_id  | VARCHAR(20)  | Unique instructor ID       |
| specialization | VARCHAR(100) | Language specialization    |
| qualifications | TEXT         | Qualifications             |
| status         | ENUM         | active/inactive            |
| created_at     | DATETIME     | Creation timestamp         |
| updated_at     | DATETIME     | Update timestamp           |
| deleted_at     | DATETIME     | Soft delete timestamp      |

#### 8. `classrooms`

Stores classroom information.

| Field      | Type         | Description                |
| ---------- | ------------ | -------------------------- |
| id         | INT          | Auto-increment primary key |
| name       | VARCHAR(100) | Classroom name             |
| capacity   | INT          | Maximum capacity           |
| location   | VARCHAR(100) | Location                   |
| facilities | JSON         | Classroom facilities       |
| status     | ENUM         | active/inactive            |
| created_at | DATETIME     | Creation timestamp         |
| updated_at | DATETIME     | Update timestamp           |
| deleted_at | DATETIME     | Soft delete timestamp      |

#### 9. `conversations`

Stores messaging conversations.

| Field      | Type         | Description                |
| ---------- | ------------ | -------------------------- |
| id         | INT          | Auto-increment primary key |
| name       | VARCHAR(255) | Conversation name          |
| type       | ENUM         | direct/group               |
| created_by | INT          | Creator user ID            |
| created_at | DATETIME     | Creation timestamp         |
| updated_at | DATETIME     | Update timestamp           |

#### 10. `messages`

Stores messages in conversations.

| Field           | Type     | Description                |
| --------------- | -------- | -------------------------- |
| id              | INT      | Auto-increment primary key |
| conversation_id | INT      | FK to conversations.id     |
| sender_id       | INT      | Sender user ID             |
| content         | TEXT     | Message content            |
| is_read         | BOOLEAN  | Read status                |
| created_at      | DATETIME | Creation timestamp         |

#### 11. `conversation_participants`

Links users to conversations.

| Field           | Type     | Description                |
| --------------- | -------- | -------------------------- |
| id              | INT      | Auto-increment primary key |
| conversation_id | INT      | FK to conversations.id     |
| user_id         | INT      | FK to users.id             |
| joined_at       | DATETIME | Join timestamp             |

#### 12. `profiles`

Stores user profile information.

| Field      | Type         | Description                |
| ---------- | ------------ | -------------------------- |
| id         | INT          | Auto-increment primary key |
| user_id    | INT          | FK to users.id             |
| full_name  | VARCHAR(100) | Full name                  |
| phone      | VARCHAR(15)  | Phone number               |
| address    | TEXT         | Address                    |
| position   | VARCHAR(100) | Job position               |
| avatar     | VARCHAR(255) | Avatar filename            |
| created_at | DATETIME     | Creation timestamp         |
| updated_at | DATETIME     | Update timestamp           |

---

## API Routes & Endpoints

### Frontend Module (Public)

| Method | Route               | Controller::Method                | Description           |
| ------ | ------------------- | --------------------------------- | --------------------- |
| GET    | `/`                 | PageController::index             | Home page             |
| GET    | `/about`            | PageController::about             | About page            |
| GET    | `/contact`          | PageController::contact           | Contact page          |
| GET    | `/programs`         | PageController::programs          | Programs listing      |
| GET    | `/programs/:id`     | PageController::programDetail     | Program detail        |
| GET    | `/mandarin`         | PageController::mandarin          | Mandarin landing page |
| GET    | `/japanese`         | PageController::japanese          | Japanese landing page |
| GET    | `/korean`           | PageController::korean            | Korean landing page   |
| GET    | `/german`           | PageController::german            | German landing page   |
| GET    | `/english`          | PageController::english           | English landing page  |
| GET    | `/apply`            | PageController::apply             | Application form      |
| POST   | `/apply/submit`     | PageController::submitApplication | Submit application    |
| GET    | `/apply/success`    | PageController::applySuccess      | Success page          |
| GET    | `/apply/:programId` | PageController::applyWithProgram  | Apply with program    |

### Account Module (Authenticated)

| Method | Route             | Controller::Method        | Description    |
| ------ | ----------------- | ------------------------- | -------------- |
| GET    | `/account`        | ProfileController::index  | Profile view   |
| GET    | `/account/create` | ProfileController::create | Create profile |
| POST   | `/account/store`  | ProfileController::store  | Store profile  |
| GET    | `/account/edit`   | ProfileController::edit   | Edit profile   |
| POST   | `/account/update` | ProfileController::update | Update profile |

### Admission Module (Staff/Admin)

#### Web Routes

| Method | Route                              | Controller::Method                    | Description          |
| ------ | ---------------------------------- | ------------------------------------- | -------------------- |
| GET    | `/admission`                       | AdmissionController::index            | Admission list       |
| GET    | `/admission/view/:id`              | AdmissionController::view             | View admission       |
| GET    | `/admission/download/:id/:file`    | AdmissionController::downloadDocument | Download document    |
| GET    | `/admission/create`                | AdmissionController::create           | Create admission     |
| POST   | `/admission/store`                 | AdmissionController::store            | Store admission      |
| GET    | `/admission/edit/:id`              | AdmissionController::edit             | Edit admission       |
| POST   | `/admission/update/:id`            | AdmissionController::update           | Update admission     |
| GET    | `/admission/promote/:id`           | AdmissionController::promote          | Promote to student   |
| POST   | `/admission/process_promotion/:id` | AdmissionController::processPromotion | Process promotion    |
| POST   | `/admission/update-status`         | AdmissionController::updateStatus     | Update status (AJAX) |
| DELETE | `/admission/delete/:id`            | AdmissionController::delete           | Delete admission     |
| GET    | `/admission/search`                | AdmissionController::search           | Search admissions    |
| GET    | `/admission/ajax-search`           | AdmissionController::ajaxSearch       | AJAX search          |

#### API Routes (Token Protected)

| Method | Route                    | Controller::Method             | Description       |
| ------ | ------------------------ | ------------------------------ | ----------------- |
| GET    | `/api/admissions`        | AdmissionApiController::index  | List admissions   |
| GET    | `/api/admissions/:id`    | AdmissionApiController::show   | Get admission     |
| POST   | `/api/admissions`        | AdmissionApiController::create | Create admission  |
| PUT    | `/api/admissions/:id`    | AdmissionApiController::update | Update admission  |
| DELETE | `/api/admissions/:id`    | AdmissionApiController::delete | Delete admission  |
| GET    | `/api/admissions/search` | AdmissionApiController::search | Search admissions |
| GET    | `/api/admissions/filter` | AdmissionApiController::filter | Filter admissions |

### Classroom Module (Authenticated)

| Method | Route                   | Controller::Method          | Description      |
| ------ | ----------------------- | --------------------------- | ---------------- |
| GET    | `/classroom`            | ClassroomController::index  | Classroom list   |
| GET    | `/classroom/create`     | ClassroomController::create | Create classroom |
| POST   | `/classroom/store`      | ClassroomController::store  | Store classroom  |
| GET    | `/classroom/show/:id`   | ClassroomController::show   | Show classroom   |
| GET    | `/classroom/edit/:id`   | ClassroomController::edit   | Edit classroom   |
| POST   | `/classroom/update/:id` | ClassroomController::update | Update classroom |
| POST   | `/classroom/delete/:id` | ClassroomController::delete | Delete classroom |

### Dashboard Module (Authenticated)

| Method | Route        | Controller::Method         | Description    |
| ------ | ------------ | -------------------------- | -------------- |
| GET    | `/dashboard` | DashboardController::index | Main dashboard |

### Employee Module (Admin/Superadmin/Frontline)

| Method | Route                        | Controller::Method         | Description     |
| ------ | ---------------------------- | -------------------------- | --------------- |
| GET    | `/admin/employee`            | EmployeeController::index  | Employee list   |
| GET    | `/admin/employee/view/:id`   | EmployeeController::show   | View employee   |
| GET    | `/admin/employee/create`     | EmployeeController::create | Create employee |
| POST   | `/admin/employee/store`      | EmployeeController::store  | Store employee  |
| GET    | `/admin/employee/edit/:id`   | EmployeeController::edit   | Edit employee   |
| POST   | `/admin/employee/update/:id` | EmployeeController::update | Update employee |
| DELETE | `/admin/employee/delete/:id` | EmployeeController::delete | Delete employee |

### Messaging Module (Authenticated)

#### Web Routes

| Method | Route                        | Controller::Method                      | Description         |
| ------ | ---------------------------- | --------------------------------------- | ------------------- |
| GET    | `/messages`                  | MessagingController::index              | Messages inbox      |
| GET    | `/messages/conversation/:id` | MessagingController::conversation       | Conversation view   |
| POST   | `/messages/create`           | MessagingController::createConversation | Create conversation |
| POST   | `/messages/send`             | MessagingController::sendMessage        | Send message        |

#### API Routes

| Method | Route                         | Controller::Method                       | Description       |
| ------ | ----------------------------- | ---------------------------------------- | ----------------- |
| GET    | `/messages/api/conversations` | MessagingController::apiGetConversations | Get conversations |
| GET    | `/messages/api/messages/:id`  | MessagingController::apiGetMessages      | Get messages      |
| POST   | `/messages/api/mark-read`     | MessagingController::apiMarkRead         | Mark as read      |
| GET    | `/messages/api/users/search`  | MessagingController::apiSearchUsers      | Search users      |
| GET    | `/messages/api/unread-count`  | MessagingController::apiGetUnreadCount   | Get unread count  |

### Payment Module (Authenticated)

#### Public Invoice Routes

| Method | Route                    | Controller::Method            | Description         |
| ------ | ------------------------ | ----------------------------- | ------------------- |
| GET    | `/invoice/public/:id`    | InvoiceController::publicView | Public invoice view |
| GET    | `/invoice/secure/:token` | InvoiceController::secureView | Secure invoice view |
| GET    | `/invoice/qr/:id`        | InvoiceController::generateQr | Generate QR code    |

#### Public Payment Routes

| Method | Route                    | Controller::Method               | Description      |
| ------ | ------------------------ | -------------------------------- | ---------------- |
| GET    | `/payment/public/:id`    | PaymentController::publicReceipt | Public receipt   |
| GET    | `/payment/secure/:token` | PaymentController::secureReceipt | Secure receipt   |
| GET    | `/payment/qr/:id`        | PaymentController::generateQr    | Generate QR code |

#### Payment Web Routes

| Method | Route                  | Controller::Method         | Description    |
| ------ | ---------------------- | -------------------------- | -------------- |
| GET    | `/payment`             | PaymentController::index   | Payment list   |
| GET    | `/payment/view/:id`    | PaymentController::view    | View payment   |
| GET    | `/payment/create`      | PaymentController::create  | Create payment |
| POST   | `/payment/store`       | PaymentController::store   | Store payment  |
| GET    | `/payment/edit/:id`    | PaymentController::edit    | Edit payment   |
| POST   | `/payment/update/:id`  | PaymentController::update  | Update payment |
| GET    | `/payment/receipt/:id` | PaymentController::receipt | Receipt view   |

#### Payment Reports Routes

| Method | Route                      | Controller::Method               | Description    |
| ------ | -------------------------- | -------------------------------- | -------------- |
| GET    | `/payment/reports/revenue` | PaymentController::revenueReport | Revenue report |
| GET    | `/payment/reports/overdue` | PaymentController::overdueReport | Overdue report |
| GET    | `/payment/reports/export`  | PaymentController::exportCsv     | Export CSV     |

#### Invoice Web Routes

| Method | Route                 | Controller::Method             | Description    |
| ------ | --------------------- | ------------------------------ | -------------- |
| GET    | `/invoice`            | InvoiceController::index       | Invoice list   |
| GET    | `/invoice/view/:id`   | InvoiceController::view        | View invoice   |
| GET    | `/invoice/create`     | InvoiceController::create      | Create invoice |
| POST   | `/invoice/store`      | InvoiceController::store       | Store invoice  |
| GET    | `/invoice/edit/:id`   | InvoiceController::edit        | Edit invoice   |
| POST   | `/invoice/update/:id` | InvoiceController::update      | Update invoice |
| GET    | `/invoice/cancel/:id` | InvoiceController::cancel      | Cancel invoice |
| GET    | `/invoice/pdf/:id`    | InvoiceController::downloadPdf | Download PDF   |

#### Payment API Routes

| Method | Route                            | Controller::Method                      | Description          |
| ------ | -------------------------------- | --------------------------------------- | -------------------- |
| GET    | `/api/payments`                  | PaymentApiController::index             | List payments        |
| GET    | `/api/payments/:id`              | PaymentApiController::show              | Get payment          |
| POST   | `/api/payments`                  | PaymentApiController::create            | Create payment       |
| PUT    | `/api/payments/:id`              | PaymentApiController::update            | Update payment       |
| PUT    | `/api/payments/:id/status`       | PaymentApiController::updateStatus      | Update status        |
| GET    | `/api/payments/search`           | PaymentApiController::search            | Search payments      |
| GET    | `/api/payments/filter/status`    | PaymentApiController::filterByStatus    | Filter by status     |
| GET    | `/api/payments/filter/method`    | PaymentApiController::filterByMethod    | Filter by method     |
| GET    | `/api/payments/filter/daterange` | PaymentApiController::filterByDateRange | Filter by date range |
| GET    | `/api/payments/student/:id`      | PaymentApiController::getByStudent      | Get by student       |
| GET    | `/api/payments/statistics`       | PaymentApiController::statistics        | Get statistics       |
| POST   | `/api/payments/:id/receipt`      | PaymentApiController::uploadReceipt     | Upload receipt       |
| GET    | `/api/payments/:id/receipt`      | PaymentApiController::getReceipt        | Get receipt          |

#### Invoice API Routes

| Method | Route                         | Controller::Method                   | Description      |
| ------ | ----------------------------- | ------------------------------------ | ---------------- |
| GET    | `/api/invoices`               | InvoiceApiController::index          | List invoices    |
| GET    | `/api/invoices/:id`           | InvoiceApiController::show           | Get invoice      |
| POST   | `/api/invoices`               | InvoiceApiController::create         | Create invoice   |
| PUT    | `/api/invoices/:id`           | InvoiceApiController::update         | Update invoice   |
| DELETE | `/api/invoices/:id`           | InvoiceApiController::delete         | Delete invoice   |
| GET    | `/api/invoices/search`        | InvoiceApiController::search         | Search invoices  |
| GET    | `/api/invoices/filter/status` | InvoiceApiController::filterByStatus | Filter by status |
| GET    | `/api/invoices/filter/type`   | InvoiceApiController::filterByType   | Filter by type   |
| GET    | `/api/invoices/student/:id`   | InvoiceApiController::getByStudent   | Get by student   |
| GET    | `/api/invoices/overdue`       | InvoiceApiController::getOverdue     | Get overdue      |
| GET    | `/api/invoices/:id/pdf`       | InvoiceApiController::generatePdf    | Generate PDF     |
| PUT    | `/api/invoices/:id/cancel`    | InvoiceApiController::cancel         | Cancel invoice   |

### Program Module (Authenticated)

#### Web Routes

| Method | Route                        | Controller::Method                  | Description       |
| ------ | ---------------------------- | ----------------------------------- | ----------------- |
| GET    | `/program`                   | ProgramController::index            | Program list      |
| GET    | `/program/view/:id`          | ProgramController::view             | View program      |
| GET    | `/program/create`            | ProgramController::create           | Create program    |
| POST   | `/program/store`             | ProgramController::store            | Store program     |
| GET    | `/program/edit/:id`          | ProgramController::edit             | Edit program      |
| POST   | `/program/update/:id`        | ProgramController::update           | Update program    |
| GET    | `/program/delete/:id`        | ProgramController::delete           | Delete program    |
| GET    | `/program/download-template` | ProgramController::downloadTemplate | Download template |
| POST   | `/program/bulk-upload`       | ProgramController::bulkUpload       | Bulk upload       |

#### API Routes

| Method | Route                           | Controller::Method                     | Description         |
| ------ | ------------------------------- | -------------------------------------- | ------------------- |
| GET    | `/api/programs`                 | ProgramApiController::index            | List programs       |
| GET    | `/api/programs/:id`             | ProgramApiController::show             | Get program         |
| POST   | `/api/programs`                 | ProgramApiController::create           | Create program      |
| PUT    | `/api/programs/:id`             | ProgramApiController::update           | Update program      |
| DELETE | `/api/programs/:id`             | ProgramApiController::delete           | Delete program      |
| GET    | `/api/programs/search`          | ProgramApiController::search           | Search programs     |
| GET    | `/api/programs/filter`          | ProgramApiController::filterByStatus   | Filter by status    |
| GET    | `/api/programs/filter/category` | ProgramApiController::filterByCategory | Filter by category  |
| GET    | `/api/programs/active`          | ProgramApiController::active           | Get active programs |
| GET    | `/api/programs/categories`      | ProgramApiController::categories       | Get categories      |

### Settings Module (Admin)

| Method | Route                          | Controller::Method                   | Description        |
| ------ | ------------------------------ | ------------------------------------ | ------------------ |
| GET    | `/settings`                    | SettingsController::index            | Settings view      |
| GET    | `/settings/cleanup`            | SettingsController::cleanup          | Cleanup view       |
| POST   | `/settings/cleanup`            | SettingsController::doCleanup        | Execute cleanup    |
| GET    | `/settings/test-data`          | SettingsController::testData         | Test data view     |
| POST   | `/settings/generate-test-data` | SettingsController::generateTestData | Generate test data |

### Student Module (Staff/Admin)

| Method | Route                 | Controller::Method             | Description       |
| ------ | --------------------- | ------------------------------ | ----------------- |
| GET    | `/student`            | StudentController::index       | Student list      |
| GET    | `/student/promote`    | StudentController::promoteForm | Promote form      |
| POST   | `/student/do-promote` | StudentController::doPromote   | Execute promotion |
| GET    | `/student/view/:id`   | StudentController::show        | View student      |
| GET    | `/student/edit/:id`   | StudentController::edit        | Edit student      |
| POST   | `/student/update/:id` | StudentController::update      | Update student    |

### Users Module (Authenticated)

| Method | Route                      | Controller::Method           | Description   |
| ------ | -------------------------- | ---------------------------- | ------------- |
| GET    | `/users`                   | UserController::index        | User list     |
| GET    | `/users/edit/:id`          | UserController::edit         | Edit user     |
| POST   | `/users/update/:id`        | UserController::update       | Update user   |
| GET    | `/users/toggle-status/:id` | UserController::toggleStatus | Toggle status |

### Authentication Routes (Shield)

| Method | Route          | Controller::Method                 | Description     |
| ------ | -------------- | ---------------------------------- | --------------- |
| GET    | `/login`       | LoginController::loginView         | Login page      |
| POST   | `/login`       | LoginController::loginAction       | Login action    |
| GET    | `/register`    | RegisterController::registerView   | Register page   |
| POST   | `/register`    | RegisterController::registerAction | Register action |
| GET    | `/logout`      | Shield::logout                     | Logout          |
| GET    | `/auth/a/show` | Shield::show                       | Auth actions    |

---

## Key Business Logic

### 1. Program Pricing Calculation

**Formula:**

```
Final Price = Tuition Fee × (1 - Discount / 100)
Total Cost = Final Price + Registration Fee
```

**Display Logic:**

- Main price shows discounted tuition fee
- Original price shown with strikethrough if discount > 0
- Registration fee shown separately as additional cost
- Discount badge shows percentage

### 2. Admission to Student Promotion

**Workflow:**

1. Student submits application → Status: `pending`
2. Staff reviews application → Status: `approved` or `rejected`
3. Approved admission can be promoted to student
4. Promotion creates student record linked to admission
5. Student status: `active`

### 3. Invoice Generation

**Invoice Types:**

- `registration_fee` - One-time registration fee
- `tuition_fee` - Recurring tuition fee
- `miscellaneous_fee` - Other fees

**Status Flow:**

```
unpaid → partially_paid → paid
         ↓
      expired
         ↓
      cancelled
```

### 4. Payment Processing

**Payment Methods:**

- `cash` - Cash payment
- `bank_transfer` - Bank transfer

**Status Flow:**

```
pending → paid
    ↓
  failed
    ↓
refunded
```

### 5. Program Categories

**Supported Languages:**

- Chinese (HSK certification)
- Japanese (JLPT certification)
- Korean (TOPIK certification)
- German (Goethe/CEFR certification)
- English (TOEFL/IELTS preparation)

**Subcategories:**

- Regular - Standard class schedule
- Package - Bundle of multiple courses
- Private - One-on-one instruction

**Delivery Modes:**

- Online - Remote learning
- Offline - In-person learning

---

## File Upload Structure

```
public/
├── uploads/
│   ├── programs/
│   │   └── thumbs/          # Program thumbnails
│   ├── admissions/
│   │   ├── photos/          # Student photos
│   │   └── documents/       # Admission documents
│   ├── payments/
│   │   └── receipts/        # Payment receipts
│   └── profiles/
│       └── avatars/         # User avatars
```

---

## Security & Permissions

### Permission System

| Permission         | Description       |
| ------------------ | ----------------- |
| `admission.manage` | Manage admissions |
| `program.view`     | View programs     |
| `program.manage`   | Manage programs   |
| `student.manage`   | Manage students   |

### User Groups

| Group        | Description           |
| ------------ | --------------------- |
| `superadmin` | Full system access    |
| `admin`      | Administrative access |
| `frontline`  | Front desk staff      |
| `staff`      | General staff         |
| `student`    | Student users         |

### Filters

| Filter       | Purpose                       |
| ------------ | ----------------------------- |
| `session`    | Require authenticated session |
| `permission` | Require specific permission   |
| `group`      | Require specific user group   |
| `tokens`     | API token authentication      |

---

## Landing Pages

Each language course has a dedicated landing page with:

1. **Hero Section**
   - Country flag
   - Certification badge
   - Course title (native language)
   - Meta tags (Flexible, Small Classes, Certificate, Native Speaker)
   - CTA buttons (WhatsApp consultation, Apply now)

2. **Why Learn Section**
   - Benefits of learning the language
   - Career opportunities
   - Cultural insights

3. **Programs Section**
   - Tab-based navigation by subcategory
   - Program cards with:
     - Thumbnail image
     - Category badge
     - Price (with discount display)
     - Registration fee note
     - Title
     - Mode and subcategory badges
     - Description
     - Details and Apply buttons

4. **Program Levels Section**
   - Available certification levels
   - Progress indicators

5. **Features Section**
   - Key course features
   - Learning materials
   - Support services

6. **CTA Section**
   - Final call-to-action
   - Contact information

---

## Recreating the Application

### Technology Alternatives

| Component      | Current             | Alternative Options                               |
| -------------- | ------------------- | ------------------------------------------------- |
| Backend        | CodeIgniter 4 (PHP) | Laravel, Symfony, Express.js, Django, Spring Boot |
| Database       | MySQL               | PostgreSQL, MongoDB, SQLite                       |
| Authentication | Shield              | Passport, JWT, Auth0, Firebase Auth               |
| Frontend       | Bootstrap 5         | Tailwind CSS, Material UI, Ant Design             |
| Architecture   | HMVC                | Microservices, Serverless, Monolith               |

### Key Implementation Considerations

1. **Modular Architecture**
   - Each module should be self-contained
   - Shared components in common module
   - Clear separation of concerns

2. **Database Design**
   - Use UUIDs for programs (portability)
   - Use auto-increment for transactions (performance)
   - Soft deletes for data integrity
   - Foreign key constraints for referential integrity

3. **API Design**
   - RESTful conventions
   - Token-based authentication
   - Consistent response format
   - Proper HTTP status codes

4. **File Handling**
   - Secure file uploads
   - Image thumbnails
   - Public vs private file access
   - QR code generation for invoices/payments

5. **Business Logic**
   - Price calculation with discounts
   - Admission to student promotion
   - Invoice status management
   - Payment tracking

6. **Security**
   - Input validation
   - SQL injection prevention
   - XSS protection
   - CSRF protection
   - Role-based access control

---

## Development Notes

### CodeIgniter 4 Specifics

- **Namespaces**: `Modules\{ModuleName}\Controllers`
- **Views**: `Modules\{ModuleName}\Views`
- **Models**: `Modules\{ModuleName}\Models`
- **Routes**: Auto-loaded from `Modules/{ModuleName}/Config/Routes.php`
- **Filters**: Applied at route level for access control

### Model Conventions

- **Table Name**: Plural, lowercase (e.g., `programs`)
- **Primary Key**: `id`
- **Timestamps**: `created_at`, `updated_at`
- **Soft Deletes**: `deleted_at`
- **JSON Fields**: Automatically encoded/decoded

### View Conventions

- **Layout**: Extended from `Modules\Frontend\Views\layout`
- **Sections**: `content`, `styles`, `scripts`
- **Helpers**: `esc()`, `base_url()`, `number_format()`

---

## API Response Format

### Success Response

```json
{
  "status": "success",
  "data": { ... },
  "message": "Operation successful"
}
```

### Error Response

```json
{
  "status": "error",
  "message": "Error description",
  "errors": { ... }
}
```

---

## Testing

### Test Data Generation

Use `/settings/test-data` to generate test data:

- Sample programs
- Sample admissions
- Sample invoices
- Sample payments

### Test Accounts

See `TEST_ACCOUNTS.md` for available test accounts.

---

## Deployment Checklist

1. **Environment Setup**
   - [ ] Configure database connection
   - [ ] Set base URL
   - [ ] Configure email settings
   - [ ] Set up file permissions

2. **Database Migration**
   - [ ] Run all migrations
   - [ ] Seed initial data
   - [ ] Create admin user

3. **File System**
   - [ ] Create upload directories
   - [ ] Set up junction/symlink for public access
   - [ ] Configure file permissions

4. **Security**
   - [ ] Generate encryption key
   - [ ] Configure session settings
   - [ ] Set up CSRF protection
   - [ ] Configure rate limiting

5. **Monitoring**
   - [ ] Set up error logging
   - [ ] Configure backup strategy
   - [ ] Set up monitoring alerts

---

## Maintenance

### Regular Tasks

1. **Database Cleanup**
   - Use `/settings/cleanup` to remove soft-deleted records
   - Archive old records
   - Optimize tables

2. **Backup**
   - Daily database backups
   - File system backups
   - Off-site storage

3. **Updates**
   - Update dependencies
   - Apply security patches
   - Test before deployment

---

## Support & Documentation

- **API Documentation**: `API_DOCUMENTATION.md`
- **Application Workflow**: `APPLICATION_WORKFLOW.md`
- **Roles & Permissions**: `ROLES_AND_PERMISSIONS.md`
- **Test Accounts**: `TEST_ACCOUNTS.md`

---

_Last Updated: 2026-02-10_
