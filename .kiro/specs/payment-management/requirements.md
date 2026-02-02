# Requirements Document: Payment Management Module

## Introduction

The Payment Management module is a comprehensive payment tracking and invoice management system for a CodeIgniter 4-based ERP system. It manages payment history, invoice generation, receipt creation, and payment analytics while integrating with the existing Admission module and following established architectural patterns.

## Glossary

- **Payment_System**: The payment management module that handles all payment-related operations
- **Invoice**: A document requesting payment for services or fees
- **Payment_Record**: A record of a payment transaction manually entered by an administrator
- **Receipt**: A document confirming payment has been received
- **Receipt_File**: An uploaded image or PDF file of a physical payment receipt
- **Payment_Method**: The mechanism used to make a payment (cash, bank transfer)
- **Payment_Status**: The current state of a payment (pending, paid, failed, refunded)
- **Document_Number**: A reference number for the payment (invoice number, bank transfer code, receipt number)
- **Registration_Number**: A unique identifier for a student in the system
- **Admission_Module**: The existing module that manages student admissions
- **Dashboard_Module**: The existing module that displays system statistics and analytics
- **API_Endpoint**: RESTful API route that returns JSON responses
- **PDF_Generator**: Component responsible for generating PDF documents

## Requirements

### Requirement 1: Payment Record Management

**User Story:** As an administrator, I want to manually create and track payment records, so that I can maintain accurate financial records for all student transactions.

#### Acceptance Criteria

1. WHEN an administrator creates a payment record, THE Payment_System SHALL store the student registration number, payment amount, payment method, document number, payment date, and optional receipt file
2. THE Payment_System SHALL validate that the registration number corresponds to an existing student
3. THE Payment_System SHALL require a document number for each payment record
4. WHEN a payment method is bank transfer or cash, THE Payment_System SHALL allow uploading a receipt file
5. WHEN retrieving payment records, THE Payment_System SHALL return all stored payment information including student details and timestamps
6. THE Payment_System SHALL associate each payment record with a specific student via registration number

### Requirement 2: Invoice Generation and Management

**User Story:** As an administrator, I want to generate and manage invoices for students, so that I can request payment for registration fees and tuition fees.

#### Acceptance Criteria

1. WHEN an invoice is created for a student, THE Payment_System SHALL generate a unique invoice number
2. THE Payment_System SHALL store invoice details including student registration number, amount, due date, description, and invoice type
3. WHEN an invoice is generated, THE Payment_System SHALL set its initial status to "unpaid"
4. WHEN a payment is recorded for an invoice, THE Payment_System SHALL update the invoice status to "paid"
5. THE Payment_System SHALL support multiple invoice types (registration fee, tuition fee, miscellaneous fee)
6. WHEN retrieving invoices, THE Payment_System SHALL return all invoice details with associated student and payment information

### Requirement 3: Payment Status Tracking

**User Story:** As an administrator, I want to track payment statuses, so that I can monitor which payments are pending, completed, or require attention.

#### Acceptance Criteria

1. THE Payment_System SHALL support four payment statuses: pending, paid, failed, and refunded
2. WHEN a payment status changes, THE Payment_System SHALL record the timestamp of the change
3. WHEN a payment is marked as failed, THE Payment_System SHALL allow recording a failure reason
4. WHEN a payment is marked as refunded, THE Payment_System SHALL record the refund date and reason
5. THE Payment_System SHALL prevent invalid status transitions (e.g., from refunded to pending)

### Requirement 4: Payment Method Support

**User Story:** As an administrator, I want to support multiple payment methods, so that I can record how students make their payments.

#### Acceptance Criteria

1. THE Payment_System SHALL support two payment methods: cash and bank transfer
2. WHEN a payment method is bank transfer, THE Payment_System SHALL require a document number (bank transfer code)
3. WHEN a payment method is cash, THE Payment_System SHALL require a document number (receipt number)
4. WHEN a receipt file is uploaded, THE Payment_System SHALL validate the file format (PDF, JPG, PNG)
5. THE Payment_System SHALL store uploaded receipt files securely and associate them with payment records

### Requirement 5: PDF Receipt and Invoice Generation

**User Story:** As an administrator, I want to generate PDF receipts and invoices, so that I can provide official documentation to payers.

#### Acceptance Criteria

1. WHEN a payment is marked as paid, THE Payment_System SHALL generate a PDF receipt
2. WHEN an invoice is created, THE Payment_System SHALL provide functionality to generate a PDF invoice
3. THE PDF_Generator SHALL include all relevant payment or invoice details in the generated document
4. THE PDF_Generator SHALL apply the system theme (dark red gradient #8B0000 to #6B0000) to generated documents
5. THE Payment_System SHALL store references to generated PDF files for future retrieval

### Requirement 6: Payment Reminders

**User Story:** As an administrator, I want to identify pending payments and overdue invoices, so that I can send payment reminders to payers.

#### Acceptance Criteria

1. THE Payment_System SHALL identify invoices with status "unpaid" and due dates in the past as overdue
2. WHEN retrieving overdue invoices, THE Payment_System SHALL return invoice details with associated payer information
3. THE Payment_System SHALL calculate the number of days overdue for each overdue invoice
4. THE Payment_System SHALL provide a list of all pending payments with their due dates

### Requirement 7: Dashboard Integration

**User Story:** As an administrator, I want to view payment statistics on the dashboard, so that I can monitor financial performance at a glance.

#### Acceptance Criteria

1. THE Payment_System SHALL provide total revenue for a specified time period
2. THE Payment_System SHALL provide count of pending payments
3. THE Payment_System SHALL provide count of completed payments for a specified time period
4. THE Payment_System SHALL provide count of overdue invoices
5. THE Payment_System SHALL provide revenue breakdown by payment method
6. THE Payment_System SHALL provide revenue breakdown by payment type (registration fee, tuition fee)

### Requirement 8: RESTful API Endpoints

**User Story:** As a frontend developer, I want to access payment data through RESTful API endpoints, so that I can integrate payment functionality into the frontend application.

#### Acceptance Criteria

1. THE Payment_System SHALL provide API endpoints that return JSON responses
2. THE Payment_System SHALL provide an endpoint to retrieve all payments with pagination support
3. THE Payment_System SHALL provide an endpoint to retrieve a single payment by ID
4. THE Payment_System SHALL provide an endpoint to create a new payment record
5. THE Payment_System SHALL provide an endpoint to update payment status
6. THE Payment_System SHALL provide an endpoint to retrieve all invoices with pagination support
7. THE Payment_System SHALL provide an endpoint to retrieve a single invoice by ID
8. THE Payment_System SHALL provide an endpoint to generate invoice PDFs
9. THE Payment_System SHALL provide an endpoint to generate receipt PDFs
10. WHEN API requests fail validation, THE Payment_System SHALL return appropriate HTTP status codes with error messages

### Requirement 9: Search and Filter Capabilities

**User Story:** As an administrator, I want to search and filter payment records, so that I can quickly find specific transactions or analyze payment patterns.

#### Acceptance Criteria

1. THE Payment_System SHALL support filtering payments by payment status
2. THE Payment_System SHALL support filtering payments by payment method
3. THE Payment_System SHALL support filtering payments by date range
4. THE Payment_System SHALL support searching payments by student registration number
5. THE Payment_System SHALL support searching payments by student name
6. THE Payment_System SHALL support searching payments by document number
7. THE Payment_System SHALL support searching invoices by invoice number
8. WHEN multiple filters are applied, THE Payment_System SHALL return results matching all filter criteria

### Requirement 10: Payment Reports and Analytics

**User Story:** As an administrator, I want to generate payment reports and view analytics, so that I can analyze financial trends and make informed decisions.

#### Acceptance Criteria

1. THE Payment_System SHALL generate a revenue report for a specified date range
2. THE Payment_System SHALL generate a payment method distribution report
3. THE Payment_System SHALL generate an overdue payments report
4. THE Payment_System SHALL generate a refund report showing all refunded transactions
5. THE Payment_System SHALL provide monthly revenue trends for the current year
6. WHEN generating reports, THE Payment_System SHALL support exporting data in CSV format

### Requirement 11: Database Integration

**User Story:** As a system architect, I want the payment module to integrate with the MySQL database, so that payment data is persisted reliably.

#### Acceptance Criteria

1. THE Payment_System SHALL store all payment records in a MySQL database table with student registration number as a foreign key
2. THE Payment_System SHALL store all invoice records in a MySQL database table with student registration number as a foreign key
3. THE Payment_System SHALL maintain referential integrity with student records through foreign keys
4. THE Payment_System SHALL store receipt file paths in the database
5. WHEN database operations fail, THE Payment_System SHALL return appropriate error messages
6. THE Payment_System SHALL use database transactions for operations that modify multiple tables

### Requirement 12: Authentication and Authorization

**User Story:** As a system administrator, I want payment operations to be protected by authentication, so that only authorized users can access payment data.

#### Acceptance Criteria

1. THE Payment_System SHALL integrate with CodeIgniter Shield for authentication
2. THE Payment_System SHALL require authentication for all payment management operations
3. THE Payment_System SHALL require authentication for all API endpoints
4. WHEN an unauthenticated request is made, THE Payment_System SHALL return HTTP 401 status code
5. WHEN an unauthorized request is made, THE Payment_System SHALL return HTTP 403 status code
