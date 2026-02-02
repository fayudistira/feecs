# Design Document: Payment Management Module

## Overview

The Payment Management module is a comprehensive payment tracking and invoice management system built for a CodeIgniter 4-based ERP system. It provides administrators with tools to manually record student payments, generate invoices, track payment statuses, upload receipt files, and generate reports. The module follows RESTful API patterns with JSON responses and integrates seamlessly with the existing modular architecture.

### Key Features

- Manual payment record entry by administrators
- Invoice generation and management for students
- Payment status tracking (pending, paid, failed, refunded)
- Receipt file uploads for cash and bank transfer payments
- PDF generation for invoices and receipts
- Payment reminders for overdue invoices
- Dashboard statistics integration
- Comprehensive search and filter capabilities
- Payment reports and analytics
- RESTful API endpoints for frontend integration

### Design Principles

- **Modular Architecture**: Self-contained module following CodeIgniter 4 HMVC pattern
- **RESTful API Design**: Consistent JSON responses with proper HTTP status codes
- **Data Integrity**: Foreign key constraints and database transactions
- **Security**: Authentication via CodeIgniter Shield, input validation
- **Maintainability**: Clear separation of concerns (Controllers, Models, Views)
- **Extensibility**: Easy to add new payment methods or invoice types

## Architecture

### Module Structure

```
app/Modules/Payment/
├── Config/
│   └── Routes.php                 # Module routes
├── Controllers/
│   ├── Api/
│   │   ├── PaymentApiController.php    # Payment API endpoints
│   │   └── InvoiceApiController.php    # Invoice API endpoints
│   ├── PaymentController.php           # Web UI for payments
│   └── InvoiceController.php           # Web UI for invoices
├── Models/
│   ├── PaymentModel.php                # Payment data access
│   └── InvoiceModel.php                # Invoice data access
├── Views/
│   ├── payments/
│   │   ├── index.php                   # Payment list view
│   │   ├── create.php                  # Create payment form
│   │   ├── edit.php                    # Edit payment form
│   │   └── view.php                    # Payment details view
│   ├── invoices/
│   │   ├── index.php                   # Invoice list view
│   │   ├── create.php                  # Create invoice form
│   │   ├── edit.php                    # Edit invoice form
│   │   └── view.php                    # Invoice details view
│   └── reports/
│       ├── revenue.php                 # Revenue report view
│       └── overdue.php                 # Overdue payments view
└── Libraries/
    └── PdfGenerator.php                # PDF generation library

app/Database/Migrations/
├── 2026_02_01_000001_create_invoices_table.php
└── 2026_02_01_000002_create_payments_table.php
```

### Technology Stack

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Authentication**: CodeIgniter Shield
- **PDF Generation**: TCPDF or Dompdf
- **File Upload**: CodeIgniter File Upload Library
- **API Format**: JSON (RESTful)

### Integration Points

1. **Student Records**: Links to students via registration_number
2. **Dashboard Module**: Provides payment statistics
3. **Authentication**: Uses CodeIgniter Shield for access control
4. **File System**: Stores uploaded receipt files

## Components and Interfaces

### 1. Payment Model

**Responsibility**: Manages payment data access and business logic

**Database Table**: `payments`

**Schema**:
```sql
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_number VARCHAR(50) NOT NULL,
    invoice_id INT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'bank_transfer') NOT NULL,
    document_number VARCHAR(100) NOT NULL,
    payment_date DATE NOT NULL,
    receipt_file VARCHAR(255) NULL,
    status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    failure_reason TEXT NULL,
    refund_date DATE NULL,
    refund_reason TEXT NULL,
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    FOREIGN KEY (registration_number) REFERENCES students(registration_number),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE SET NULL,
    INDEX idx_registration_number (registration_number),
    INDEX idx_payment_date (payment_date),
    INDEX idx_status (status),
    INDEX idx_payment_method (payment_method)
);
```

**Key Methods**:
- `createPayment($data)`: Create new payment record
- `updatePaymentStatus($id, $status, $additionalData)`: Update payment status
- `getPaymentsByStudent($registrationNumber)`: Get all payments for a student
- `getPaymentsByDateRange($startDate, $endDate)`: Get payments within date range
- `searchPayments($keyword)`: Search by student name, registration number, or document number
- `filterPayments($filters)`: Apply multiple filters (status, method, date range)
- `getOverduePayments()`: Get payments with pending status past due date
- `getRevenueByMethod()`: Get revenue breakdown by payment method
- `getRevenueByDateRange($startDate, $endDate)`: Calculate total revenue
- `uploadReceiptFile($file)`: Handle receipt file upload

**Validation Rules**:
- `registration_number`: required, exists in students table
- `amount`: required, numeric, greater than 0
- `payment_method`: required, in_list[cash,bank_transfer]
- `document_number`: required, max_length[100]
- `payment_date`: required, valid_date
- `receipt_file`: optional, uploaded file, max_size[2048], ext_in[pdf,jpg,jpeg,png]
- `status`: optional, in_list[pending,paid,failed,refunded]

### 2. Invoice Model

**Responsibility**: Manages invoice data access and business logic

**Database Table**: `invoices`

**Schema**:
```sql
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    registration_number VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE NOT NULL,
    invoice_type ENUM('registration_fee', 'tuition_fee', 'miscellaneous_fee') NOT NULL,
    status ENUM('unpaid', 'paid', 'cancelled') DEFAULT 'unpaid',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    FOREIGN KEY (registration_number) REFERENCES students(registration_number),
    INDEX idx_registration_number (registration_number),
    INDEX idx_invoice_number (invoice_number),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date)
);
```

**Key Methods**:
- `createInvoice($data)`: Create new invoice with auto-generated invoice number
- `generateInvoiceNumber()`: Generate unique invoice number (format: INV-YYYY-NNNN)
- `updateInvoiceStatus($id, $status)`: Update invoice status
- `getInvoicesByStudent($registrationNumber)`: Get all invoices for a student
- `getOverdueInvoices()`: Get unpaid invoices past due date
- `searchInvoices($keyword)`: Search by invoice number or student name
- `filterInvoices($filters)`: Apply multiple filters (status, type, date range)
- `linkPaymentToInvoice($invoiceId, $paymentId)`: Associate payment with invoice
- `getInvoiceWithPayments($id)`: Get invoice with associated payment records

**Validation Rules**:
- `registration_number`: required, exists in students table
- `description`: required, min_length[10]
- `amount`: required, numeric, greater than 0
- `due_date`: required, valid_date
- `invoice_type`: required, in_list[registration_fee,tuition_fee,miscellaneous_fee]
- `status`: optional, in_list[unpaid,paid,cancelled]

### 3. Payment API Controller

**Responsibility**: Handle RESTful API requests for payment operations

**Base Path**: `/api/payments`

**Endpoints**:

1. **GET /api/payments** - List all payments with pagination
   - Query params: `page`, `per_page`, `status`, `method`, `start_date`, `end_date`
   - Response: Paginated payment list with student details

2. **GET /api/payments/{id}** - Get single payment details
   - Response: Payment details with student and invoice information

3. **POST /api/payments** - Create new payment record
   - Request body: payment data with optional file upload
   - Response: Created payment with HTTP 201

4. **PUT /api/payments/{id}** - Update payment record
   - Request body: partial payment data
   - Response: Updated payment details

5. **PUT /api/payments/{id}/status** - Update payment status
   - Request body: `{status, failure_reason?, refund_date?, refund_reason?}`
   - Response: Updated payment with new status

6. **GET /api/payments/search** - Search payments
   - Query params: `q` (keyword)
   - Response: Matching payments

7. **GET /api/payments/student/{registrationNumber}** - Get student payments
   - Response: All payments for specific student

8. **GET /api/payments/overdue** - Get overdue payments
   - Response: Payments with pending status past due date

9. **GET /api/payments/statistics** - Get payment statistics
   - Query params: `start_date`, `end_date`
   - Response: Revenue totals, counts by status, breakdown by method

10. **POST /api/payments/{id}/receipt** - Upload receipt file
    - Request: multipart/form-data with file
    - Response: Updated payment with receipt file path

### 4. Invoice API Controller

**Responsibility**: Handle RESTful API requests for invoice operations

**Base Path**: `/api/invoices`

**Endpoints**:

1. **GET /api/invoices** - List all invoices with pagination
   - Query params: `page`, `per_page`, `status`, `type`, `start_date`, `end_date`
   - Response: Paginated invoice list with student details

2. **GET /api/invoices/{id}** - Get single invoice details
   - Response: Invoice details with student and payment information

3. **POST /api/invoices** - Create new invoice
   - Request body: invoice data (invoice_number auto-generated)
   - Response: Created invoice with HTTP 201

4. **PUT /api/invoices/{id}** - Update invoice
   - Request body: partial invoice data
   - Response: Updated invoice details

5. **DELETE /api/invoices/{id}** - Delete invoice (soft delete)
   - Response: Success message

6. **GET /api/invoices/search** - Search invoices
   - Query params: `q` (keyword)
   - Response: Matching invoices

7. **GET /api/invoices/student/{registrationNumber}** - Get student invoices
   - Response: All invoices for specific student

8. **GET /api/invoices/overdue** - Get overdue invoices
   - Response: Unpaid invoices past due date with days overdue

9. **GET /api/invoices/{id}/pdf** - Generate invoice PDF
   - Response: PDF file download

10. **PUT /api/invoices/{id}/cancel** - Cancel invoice
    - Response: Invoice with cancelled status

### 5. PDF Generator Library

**Responsibility**: Generate PDF documents for invoices and receipts

**Class**: `PdfGenerator`

**Methods**:

1. `generateInvoicePdf($invoiceData)`: Generate invoice PDF
   - Input: Invoice data with student details
   - Output: PDF file path
   - Includes: Invoice number, student info, amount, due date, description, system theme

2. `generateReceiptPdf($paymentData)`: Generate payment receipt PDF
   - Input: Payment data with student and invoice details
   - Output: PDF file path
   - Includes: Receipt number, payment date, amount, method, student info, system theme

3. `applyTheme($pdf)`: Apply dark red gradient theme to PDF
   - Colors: #8B0000 to #6B0000
   - Applies to headers and borders

**PDF Structure**:
```
┌─────────────────────────────────────┐
│ [LOGO]  ERP System                  │ ← Dark red gradient header
│                                     │
│ INVOICE / RECEIPT                   │
│ Number: INV-2026-0001               │
│ Date: 2026-02-01                    │
├─────────────────────────────────────┤
│ Student Information:                │
│ Name: John Doe                      │
│ Registration: ADM-2026-001          │
├─────────────────────────────────────┤
│ Payment Details:                    │
│ Description: Registration Fee       │
│ Amount: $500.00                     │
│ Due Date: 2026-02-15                │
│ Payment Method: Bank Transfer       │
│ Document Number: TRX-123456         │
├─────────────────────────────────────┤
│ Total: $500.00                      │
└─────────────────────────────────────┘
```

### 6. Dashboard Integration

**Responsibility**: Provide payment statistics for dashboard display

**Methods in PaymentModel**:

1. `getDashboardStatistics($startDate, $endDate)`: Get comprehensive statistics
   - Total revenue
   - Pending payments count
   - Completed payments count
   - Overdue invoices count
   - Revenue by payment method
   - Revenue by invoice type
   - Monthly revenue trend

**Dashboard Widget Data Structure**:
```php
[
    'total_revenue' => 125000.00,
    'pending_count' => 15,
    'completed_count' => 230,
    'overdue_count' => 8,
    'revenue_by_method' => [
        'cash' => 45000.00,
        'bank_transfer' => 80000.00
    ],
    'revenue_by_type' => [
        'registration_fee' => 50000.00,
        'tuition_fee' => 70000.00,
        'miscellaneous_fee' => 5000.00
    ],
    'monthly_trend' => [
        ['month' => 'January', 'revenue' => 45000.00],
        ['month' => 'February', 'revenue' => 80000.00]
    ]
]
```

## Data Models

### Payment Entity

```php
class Payment {
    public int $id;
    public string $registration_number;
    public ?int $invoice_id;
    public float $amount;
    public string $payment_method;      // 'cash' | 'bank_transfer'
    public string $document_number;
    public string $payment_date;        // YYYY-MM-DD
    public ?string $receipt_file;
    public string $status;              // 'pending' | 'paid' | 'failed' | 'refunded'
    public ?string $failure_reason;
    public ?string $refund_date;
    public ?string $refund_reason;
    public ?string $notes;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
    
    // Relationships
    public Student $student;
    public ?Invoice $invoice;
}
```

### Invoice Entity

```php
class Invoice {
    public int $id;
    public string $invoice_number;      // INV-YYYY-NNNN
    public string $registration_number;
    public string $description;
    public float $amount;
    public string $due_date;            // YYYY-MM-DD
    public string $invoice_type;        // 'registration_fee' | 'tuition_fee' | 'miscellaneous_fee'
    public string $status;              // 'unpaid' | 'paid' | 'cancelled'
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
    
    // Relationships
    public Student $student;
    public array $payments;             // Payment[]
    
    // Computed properties
    public int $days_overdue;           // Calculated if status='unpaid' and due_date < today
}
```

### Student Entity (Reference)

```php
class Student {
    public string $registration_number;  // Primary key
    public string $full_name;
    public string $email;
    public string $phone;
    // ... other fields from Admission module
}
```

### API Response Formats

**Success Response**:
```json
{
    "status": "success",
    "data": { ... },
    "message": "Optional success message"
}
```

**Error Response**:
```json
{
    "status": "error",
    "message": "Error description",
    "errors": {
        "field_name": "Validation error message"
    }
}
```

**Paginated Response**:
```json
{
    "status": "success",
    "data": [ ... ],
    "pagination": {
        "current_page": 1,
        "total_pages": 10,
        "per_page": 10,
        "total": 95
    }
}
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Payment Data Persistence

*For any* payment record created with valid data (registration number, amount, payment method, document number, payment date), retrieving that payment should return all the originally stored fields including student details and timestamps.

**Validates: Requirements 1.1, 1.5**

### Property 2: Student Registration Validation

*For any* registration number used in a payment or invoice, the system should only accept registration numbers that correspond to existing students in the database.

**Validates: Requirements 1.2**

### Property 3: Document Number Requirement

*For any* payment record, attempting to create it without a document number should fail validation.

**Validates: Requirements 1.3**

### Property 4: Receipt File Upload

*For any* payment with method "cash" or "bank_transfer", uploading a valid receipt file (PDF, JPG, PNG under 2MB) should succeed and the file path should be stored with the payment record.

**Validates: Requirements 1.4, 4.5**

### Property 5: Payment-Student Association

*For any* payment record, retrieving the payment should include the associated student information accessible via the registration number.

**Validates: Requirements 1.6**

### Property 6: Invoice Number Uniqueness

*For any* set of invoices created in the system, all invoice numbers should be unique (no duplicates).

**Validates: Requirements 2.1**

### Property 7: Invoice Data Persistence

*For any* invoice created with valid data (registration number, description, amount, due date, invoice type), retrieving that invoice should return all the originally stored fields including student and payment information.

**Validates: Requirements 2.2, 2.6**

### Property 8: Invoice Initial Status

*For any* newly created invoice, its status should be set to "unpaid" by default.

**Validates: Requirements 2.3**

### Property 9: Invoice Status Update on Payment

*For any* invoice with status "unpaid", when a payment is recorded and linked to that invoice, the invoice status should update to "paid".

**Validates: Requirements 2.4**

### Property 10: Invoice Type Support

*For any* invoice type from the set {registration_fee, tuition_fee, miscellaneous_fee}, creating an invoice with that type should succeed.

**Validates: Requirements 2.5**

### Property 11: Payment Status Support

*For any* payment status from the set {pending, paid, failed, refunded}, creating or updating a payment with that status should succeed.

**Validates: Requirements 3.1**

### Property 12: Status Change Timestamp

*For any* payment, when its status is updated, the updated_at timestamp should change to reflect the current time.

**Validates: Requirements 3.2**

### Property 13: Failed Payment Reason

*For any* payment with status "failed", the system should allow storing a failure_reason field.

**Validates: Requirements 3.3**

### Property 14: Refund Information

*For any* payment with status "refunded", the system should allow storing both refund_date and refund_reason fields.

**Validates: Requirements 3.4**

### Property 15: Invalid Status Transitions

*For any* payment with status "refunded", attempting to change its status to "pending" should be rejected by the system.

**Validates: Requirements 3.5**

### Property 16: Payment Method Support

*For any* payment method from the set {cash, bank_transfer}, creating a payment with that method should succeed, and any method outside this set should be rejected.

**Validates: Requirements 4.1**

### Property 17: Receipt File Format Validation

*For any* file uploaded as a receipt, the system should only accept files with extensions {pdf, jpg, jpeg, png} and reject all other formats.

**Validates: Requirements 4.4**

### Property 18: PDF Receipt Generation

*For any* payment marked with status "paid", the system should generate a PDF receipt and store the file path.

**Validates: Requirements 5.1**

### Property 19: PDF Invoice Generation

*For any* invoice, calling the PDF generation function should create a PDF file and return its file path.

**Validates: Requirements 5.2**

### Property 20: PDF Content Completeness

*For any* generated invoice or receipt PDF, the document should contain all required fields: invoice/receipt number, student name, registration number, amount, date, and description/payment method.

**Validates: Requirements 5.3**

### Property 21: PDF File Path Storage

*For any* generated PDF (invoice or receipt), the file path should be stored in the database and retrievable.

**Validates: Requirements 5.5**

### Property 22: Overdue Invoice Identification

*For any* invoice with status "unpaid" and due_date less than today's date, the system should identify it as overdue.

**Validates: Requirements 6.1**

### Property 23: Overdue Invoice Data

*For any* overdue invoice retrieved, the response should include the invoice details and the associated student information.

**Validates: Requirements 6.2**

### Property 24: Days Overdue Calculation

*For any* overdue invoice, the calculated days_overdue should equal the number of days between the due_date and today's date.

**Validates: Requirements 6.3**

### Property 25: Pending Payments List

*For any* query for pending payments, all returned payments should have status "pending".

**Validates: Requirements 6.4**

### Property 26: Revenue Calculation

*For any* date range, the total revenue should equal the sum of all payment amounts with status "paid" where payment_date falls within that range.

**Validates: Requirements 7.1**

### Property 27: Pending Payment Count

*For any* query for pending payment count, the count should equal the number of payments with status "pending".

**Validates: Requirements 7.2**

### Property 28: Completed Payment Count

*For any* date range, the completed payment count should equal the number of payments with status "paid" where payment_date falls within that range.

**Validates: Requirements 7.3**

### Property 29: Overdue Invoice Count

*For any* query for overdue invoice count, the count should equal the number of invoices with status "unpaid" and due_date less than today.

**Validates: Requirements 7.4**

### Property 30: Revenue by Payment Method

*For any* date range, the revenue breakdown by payment method should equal the sum of payment amounts grouped by payment_method for payments with status "paid" in that range.

**Validates: Requirements 7.5**

### Property 31: Revenue by Invoice Type

*For any* date range, the revenue breakdown by invoice type should equal the sum of payment amounts grouped by the linked invoice's invoice_type for payments with status "paid" in that range.

**Validates: Requirements 7.6**

### Property 32: JSON Response Format

*For any* API endpoint called, the response should be valid JSON with a "status" field containing either "success" or "error".

**Validates: Requirements 8.1**

### Property 33: Payment Pagination

*For any* request to list payments with pagination parameters (page, per_page), the response should contain a data array and pagination object with current_page, total_pages, per_page, and total fields.

**Validates: Requirements 8.2**

### Property 34: Payment Retrieval Round Trip

*For any* payment created via the API, retrieving it by ID should return the same data that was originally submitted.

**Validates: Requirements 8.3, 8.4**

### Property 35: Payment Status Update via API

*For any* payment, calling the status update endpoint with a valid status should update the payment's status field.

**Validates: Requirements 8.5**

### Property 36: Invoice Pagination

*For any* request to list invoices with pagination parameters (page, per_page), the response should contain a data array and pagination object with current_page, total_pages, per_page, and total fields.

**Validates: Requirements 8.6**

### Property 37: Invoice Retrieval Round Trip

*For any* invoice created via the API, retrieving it by ID should return the same data that was originally submitted (including auto-generated invoice_number).

**Validates: Requirements 8.7**

### Property 38: PDF Generation Endpoints

*For any* valid invoice or payment ID, calling the PDF generation endpoint should return a PDF file with appropriate content-type header.

**Validates: Requirements 8.8, 8.9**

### Property 39: Validation Error Responses

*For any* API request with invalid data (missing required fields, invalid formats), the response should have HTTP status 422 and include an "errors" object with field-specific error messages.

**Validates: Requirements 8.10**

### Property 40: Payment Status Filter

*For any* payment status value, filtering payments by that status should return only payments with that exact status.

**Validates: Requirements 9.1**

### Property 41: Payment Method Filter

*For any* payment method value, filtering payments by that method should return only payments with that exact payment_method.

**Validates: Requirements 9.2**

### Property 42: Payment Date Range Filter

*For any* date range (start_date, end_date), filtering payments by that range should return only payments where payment_date is between start_date and end_date inclusive.

**Validates: Requirements 9.3**

### Property 43: Payment Search by Registration Number

*For any* registration number, searching payments by that registration number should return only payments associated with that student.

**Validates: Requirements 9.4**

### Property 44: Payment Search by Student Name

*For any* student name keyword, searching payments should return only payments where the associated student's name contains that keyword.

**Validates: Requirements 9.5**

### Property 45: Payment Search by Document Number

*For any* document number keyword, searching payments should return only payments where the document_number contains that keyword.

**Validates: Requirements 9.6**

### Property 46: Invoice Search by Invoice Number

*For any* invoice number keyword, searching invoices should return only invoices where the invoice_number contains that keyword.

**Validates: Requirements 9.7**

### Property 47: Multiple Filter Combination

*For any* combination of filters (status, method, date range), the results should match ALL filter criteria (AND logic, not OR).

**Validates: Requirements 9.8**

### Property 48: Refund Report

*For any* query for refunded transactions, all returned payments should have status "refunded".

**Validates: Requirements 10.4**

### Property 49: Monthly Revenue Trends

*For any* year, the monthly revenue trend should show the sum of payment amounts with status "paid" grouped by month for that year.

**Validates: Requirements 10.5**

### Property 50: CSV Export Format

*For any* report exported to CSV, the file should be valid CSV format with headers in the first row and data in subsequent rows.

**Validates: Requirements 10.6**

### Property 51: Authentication Requirement

*For any* API endpoint in the payment module, making a request without authentication credentials should return HTTP status 401.

**Validates: Requirements 12.2**

### Property 52: Authorization Check

*For any* API endpoint in the payment module, making an authenticated request without proper permissions should return HTTP status 403.

**Validates: Requirements 12.5**

## Error Handling

### Validation Errors

**Strategy**: Use CodeIgniter 4's built-in validation library with custom rules

**Common Validation Scenarios**:
1. Missing required fields → HTTP 422 with field-specific errors
2. Invalid data types → HTTP 422 with type mismatch errors
3. Invalid foreign keys → HTTP 422 with "Student not found" error
4. Invalid enum values → HTTP 422 with "Invalid status/method/type" error
5. File upload errors → HTTP 422 with file-specific errors

**Example Error Response**:
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "registration_number": "Student with this registration number does not exist",
        "amount": "Amount must be greater than 0",
        "payment_method": "Payment method must be either cash or bank_transfer"
    }
}
```

### Database Errors

**Strategy**: Wrap database operations in try-catch blocks

**Scenarios**:
1. Connection failures → HTTP 500 with generic error message
2. Constraint violations → HTTP 422 with specific constraint error
3. Duplicate key errors → HTTP 422 with "Record already exists" error
4. Transaction failures → HTTP 500 with rollback message

**Example Error Response**:
```json
{
    "status": "error",
    "message": "Database operation failed",
    "errors": {
        "database": "Unable to save payment record. Please try again."
    }
}
```

### File Upload Errors

**Strategy**: Validate file before processing

**Scenarios**:
1. File too large → HTTP 422 with size limit error
2. Invalid file type → HTTP 422 with allowed types error
3. Upload failure → HTTP 500 with upload error message
4. Storage failure → HTTP 500 with storage error message

**Example Error Response**:
```json
{
    "status": "error",
    "message": "File upload failed",
    "errors": {
        "receipt_file": "File size exceeds 2MB limit. Allowed formats: PDF, JPG, PNG"
    }
}
```

### PDF Generation Errors

**Strategy**: Handle PDF library exceptions gracefully

**Scenarios**:
1. Missing data → HTTP 422 with "Incomplete data for PDF generation"
2. Template errors → HTTP 500 with "PDF generation failed"
3. File write errors → HTTP 500 with "Unable to save PDF file"

**Example Error Response**:
```json
{
    "status": "error",
    "message": "PDF generation failed",
    "errors": {
        "pdf": "Unable to generate PDF. Please contact support."
    }
}
```

### Authentication/Authorization Errors

**Strategy**: Use CodeIgniter Shield middleware

**Scenarios**:
1. No auth token → HTTP 401 with "Authentication required"
2. Invalid token → HTTP 401 with "Invalid credentials"
3. Expired token → HTTP 401 with "Session expired"
4. Insufficient permissions → HTTP 403 with "Access denied"

**Example Error Responses**:
```json
{
    "status": "error",
    "message": "Authentication required",
    "errors": {
        "auth": "You must be logged in to access this resource"
    }
}
```

```json
{
    "status": "error",
    "message": "Access denied",
    "errors": {
        "auth": "You do not have permission to perform this action"
    }
}
```

### Business Logic Errors

**Strategy**: Validate business rules before database operations

**Scenarios**:
1. Invalid status transition → HTTP 422 with transition error
2. Payment exceeds invoice amount → HTTP 422 with amount error
3. Duplicate payment for invoice → HTTP 422 with duplicate error
4. Modifying paid invoice → HTTP 422 with immutability error

**Example Error Response**:
```json
{
    "status": "error",
    "message": "Invalid operation",
    "errors": {
        "status": "Cannot change status from 'refunded' to 'pending'"
    }
}
```

## Testing Strategy

### Dual Testing Approach

The Payment Management module will use both **unit testing** and **property-based testing** to ensure comprehensive coverage and correctness.

**Unit Tests**: Focus on specific examples, edge cases, and integration points
- Test specific payment scenarios (cash payment, bank transfer)
- Test edge cases (zero amount, past dates, missing optional fields)
- Test error conditions (invalid registration number, file upload failures)
- Test integration with student records and invoice linking
- Test PDF generation with specific data
- Test authentication and authorization middleware

**Property-Based Tests**: Verify universal properties across all inputs
- Test that all correctness properties hold for randomly generated data
- Use a PHP property-based testing library (e.g., Eris or php-quickcheck)
- Each property test should run minimum 100 iterations
- Tag each test with the property number and description

### Property-Based Testing Configuration

**Library**: Eris (PHP property-based testing library)

**Configuration**:
```php
// In tests/PropertyTests/PaymentPropertyTest.php
use Eris\Generator;
use Eris\TestTrait;

class PaymentPropertyTest extends TestCase
{
    use TestTrait;
    
    /**
     * Feature: payment-management, Property 1: Payment Data Persistence
     * For any payment record created with valid data, retrieving that payment
     * should return all the originally stored fields.
     */
    public function testPaymentDataPersistence()
    {
        $this->forAll(
            Generator::associative([
                'registration_number' => Generator::elements($this->getValidRegistrationNumbers()),
                'amount' => Generator::float(1.0, 10000.0),
                'payment_method' => Generator::elements(['cash', 'bank_transfer']),
                'document_number' => Generator::string(),
                'payment_date' => Generator::date('Y-m-d')
            ])
        )
        ->withMaxSize(100)
        ->then(function ($paymentData) {
            // Create payment
            $payment = $this->paymentModel->create($paymentData);
            
            // Retrieve payment
            $retrieved = $this->paymentModel->find($payment['id']);
            
            // Assert all fields match
            $this->assertEquals($paymentData['registration_number'], $retrieved['registration_number']);
            $this->assertEquals($paymentData['amount'], $retrieved['amount']);
            $this->assertEquals($paymentData['payment_method'], $retrieved['payment_method']);
            $this->assertEquals($paymentData['document_number'], $retrieved['document_number']);
            $this->assertEquals($paymentData['payment_date'], $retrieved['payment_date']);
        });
    }
}
```

**Test Organization**:
- Property tests in `tests/PropertyTests/`
- Unit tests in `tests/Unit/`
- Integration tests in `tests/Integration/`
- API tests in `tests/Api/`

**Test Coverage Goals**:
- 52 property-based tests (one per correctness property)
- 50+ unit tests for specific scenarios and edge cases
- 20+ integration tests for module interactions
- 30+ API endpoint tests

### Testing Tools

- **PHPUnit**: Primary testing framework
- **Eris**: Property-based testing library
- **Faker**: Generate realistic test data
- **CodeIgniter Testing**: Built-in testing utilities
- **HTTP Client**: Test API endpoints

### Continuous Integration

- Run all tests on every commit
- Require 100% property test pass rate
- Maintain >80% code coverage
- Run tests against MySQL database (not SQLite)

