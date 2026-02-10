# Payment Module Analysis - Receipt Print Functionality

## Executive Summary

This document provides a comprehensive analysis of the Payment Module's receipt print functionality, identifying existing components, missing implementations, and recommendations for completion.

**Status Update (2026-02-10):** Fixed issues with invoice number/student name display and implemented print receipt functionality with server-side encrypted QR code.

---

## 1.1 Recent Fixes (2026-02-10)

### Issue 1: Invoice Number and Student Name Showing as "N/A"

**Root Cause:**

- The [`index.php`](app/Modules/Payment/Views/payments/index.php) view expected `$payment['invoice_number']` and `$payment['student_name']`
- The controller's enrichment loop only set `$payment['student']` (an array) and didn't fetch invoice details
- The model's `searchPayments()` and `filterPayments()` methods didn't select these fields

**Fixes Applied:**

1. **Updated [`PaymentController::index()`](app/Modules/Payment/Controllers/PaymentController.php:59)** - Modified enrichment loop to:
   - Set `$payment['student_name']` from student's full_name
   - Fetch invoice details and set `$payment['invoice_number']`
   - Handle both paginated and search/filter results

2. **Updated [`PaymentModel::searchPayments()`](app/Modules/Payment/Models/PaymentModel.php:120)** - Added:
   - Select `profiles.full_name as student_name`
   - Left join with `invoices` table
   - Select `invoices.invoice_number`

3. **Updated [`PaymentModel::filterPayments()`](app/Modules/Payment/Models/PaymentModel.php:146)** - Added:
   - Database builder approach instead of model methods
   - Select `profiles.full_name as student_name`
   - Left join with `invoices` table
   - Select `invoices.invoice_number`

4. **Updated [`index.php`](app/Modules/Payment/Views/payments/index.php:122)** view - Added:
   - Conditional check for `invoice_id` before creating link
   - Null check for `invoice_number` to prevent broken links

**Result:** Invoice numbers and student names now display correctly on the payment index page for all data sources (pagination, search, and filters).

### Issue 2: Print Receipt Functionality Not Working

**Root Cause:**

- The receipt view template existed but had no controller method to render it
- The API route for receipt existed but the `getReceipt()` method was missing
- No route defined for accessing receipt via URL

**Fixes Applied:**

1. **Added [`PaymentController::receipt($id)`](app/Modules/Payment/Controllers/PaymentController.php:360)** - New method that:
   - Fetches payment details by ID
   - Retrieves student information with profile and program data
   - Fetches invoice details if linked
   - Sets company information (address, email, phone)
   - Generates payment number if not exists (format: PAY-YYYY-0001)
   - Renders the receipt view

2. **Added [`PaymentApiController::getReceipt($id)`](app/Modules/Payment/Controllers/Api/PaymentApiController.php:468)** - New API method that:
   - Fetches payment details by ID
   - Retrieves student information with profile and program data
   - Fetches invoice details if linked
   - Sets company information
   - Generates payment number if not exists
   - Returns HTML content for receipt (for modal display)

3. **Added Route** - Updated [`Routes.php`](app/Modules/Payment/Config/Routes.php:20) to include:

   ```php
   $routes->get('receipt/(:segment)', 'PaymentController::receipt/$1');
   ```

4. **Added Print Button** - Updated [`view.php`](app/Modules/Payment/Views/payments/view.php:22) to include:
   - "Print Receipt" button that opens receipt in new tab
   - Button uses printer icon for clarity

5. **Fixed Type Casting** - Updated [`view.php`](app/Modules/Payment/Views/payments/view.php:63) to cast `$payment['notes']` to string for `nl2br()` function.

**Result:** Print receipt functionality now works via:

- Direct URL: `/payment/receipt/{id}`
- Print button on payment index page (opens in new tab)
- Print button on payment details page (opens in new tab)

**Note:** Modal-based receipt loading has been removed in favor of direct URL access for cleaner printing experience. QR code is now generated server-side with encrypted token (`/payment/qr/{id}`) for secure/unpredictable access. The [`EmailService`](app/Services/EmailService.php) has been updated with `generatePaymentToken()` and `verifyPaymentToken()` methods.

---

## 1. Module Overview

### 1.1 Module Structure

```
app/Modules/Payment/
├── Config/
│   ├── Menu.php
│   └── Routes.php
├── Controllers/
│   ├── InvoiceController.php
│   ├── PaymentController.php
│   └── Api/
│       ├── InvoiceApiController.php
│       └── PaymentApiController.php
├── Libraries/
│   └── PdfGenerator.php
├── Models/
│   ├── InvoiceModel.php
│   └── PaymentModel.php
└── Views/
    ├── invoices/
    │   ├── create.php
    │   ├── edit.php
    │   ├── index.php
    │   ├── print.php
    │   └── view.php
    ├── payments/
    │   ├── create.php
    │   ├── edit.php
    │   ├── index.php
    │   ├── receipt.php  ← EXISTS but not connected
    │   └── view.php
    └── reports/
        ├── overdue.php
        └── revenue.php
```

---

## 2. Receipt Print Functionality Analysis

### 2.1 Existing Components

#### ✅ Receipt View File

**Location:** [`app/Modules/Payment/Views/payments/receipt.php`](app/Modules/Payment/Views/payments/receipt.php)

**Features:**

- Professional receipt layout with SOSCT branding
- Company header with address, email, and phone
- Payment metadata (number, date, time, method)
- Student information section
- Invoice information section
- Payment details with status badge
- Amount display with highlighted box
- QR code for payment verification
- Print-friendly CSS with `@media print` rules
- Responsive design

**Expected Data Variables:**

```php
$payment['payment_number']     // Payment reference number
$payment['payment_date']       // Payment date/time
$payment['payment_method']     // Payment method (cash, bank_transfer, etc.)
$payment['amount']             // Payment amount
$payment['transaction_id']     // Transaction ID (optional)
$payment['notes']              // Payment notes (optional)

$student['full_name']          // Student full name
$student['email']              // Student email
$student['phone']              // Student phone
$student['program_title']      // Program title

$invoice['invoice_number']     // Invoice number
$invoice['registration_number'] // Registration number
$invoice['invoice_type']       // Invoice type

$company['address']            // Company address
$company['email']              // Company email
$company['phone']              // Company phone
```

#### ✅ Payment Model

**Location:** [`app/Modules/Payment/Models/PaymentModel.php`](app/Modules/Payment/Models/PaymentModel.php)

**Relevant Methods:**

- [`uploadReceiptFile()`](app/Modules/Payment/Models/PaymentModel.php:214) - Handles receipt file uploads (PDF, JPG, PNG, max 2MB)
- [`getPaymentsByStudent()`](app/Modules/Payment/Models/PaymentModel.php:91) - Get payments by registration number
- [`searchPayments()`](app/Modules/Payment/Models/PaymentModel.php:120) - Search payments by keyword
- [`filterPayments()`](app/Modules/Payment/Models/PaymentModel.php:145) - Filter payments by criteria

**Allowed Fields:**

```php
'registration_number', 'invoice_id', 'amount', 'payment_method',
'document_number', 'payment_date', 'receipt_file', 'status',
'failure_reason', 'refund_date', 'refund_reason', 'notes'
```

#### ✅ Payment Controller

**Location:** [`app/Modules/Payment/Controllers/PaymentController.php`](app/Modules/Payment/Controllers/PaymentController.php)

**Existing Methods:**

- [`index()`](app/Modules/Payment/Controllers/PaymentController.php:26) - List payments with filters
- [`view($id)`](app/Modules/Payment/Controllers/PaymentController.php:84) - View payment details
- [`create()`](app/Modules/Payment/Controllers/PaymentController.php:113) - Show create form
- [`store()`](app/Modules/Payment/Controllers/PaymentController.php:125) - Store new payment
- [`edit($id)`](app/Modules/Payment/Controllers/PaymentController.php:191) - Show edit form
- [`update($id)`](app/Modules/Payment/Controllers/PaymentController.php:225) - Update payment
- [`revenueReport()`](app/Modules/Payment/Controllers/PaymentController.php:281) - Revenue report
- [`overdueReport()`](app/Modules/Payment/Controllers/PaymentController.php:316) - Overdue report
- [`exportCsv()`](app/Modules/Payment/Controllers/PaymentController.php:331) - Export to CSV

---

### 2.2 Missing Components

#### ✅ Receipt Controller Method

**Status:** IMPLEMENTED

The [`PaymentController::receipt($id)`](app/Modules/Payment/Controllers/PaymentController.php:360) method now renders the receipt view with all necessary data.

#### ✅ Receipt Route

**Status:** IMPLEMENTED

The [`Routes.php`](app/Modules/Payment/Config/Routes.php:20) now includes:

```php
$routes->get('receipt/(:segment)', 'PaymentController::receipt/$1');
```

#### ✅ Print Button in View

**Status:** IMPLEMENTED

The [`view.php`](app/Modules/Payment/Views/payments/view.php:22) now has a "Print Receipt" button that opens the receipt in a new tab.

#### ✅ API Receipt Method

**Status:** IMPLEMENTED

The [`PaymentApiController::getReceipt($id)`](app/Modules/Payment/Controllers/Api/PaymentApiController.php:468) method now returns HTML content for receipt display in modal.

---

### 2.3 Data Flow Issues

#### Issue 1: Missing Payment Number Field

The receipt view expects `$payment['payment_number']`, but the payments table schema does not include this field. The view uses `$payment['id']` in other places.

**Current Schema (from PaymentModel):**

```php
protected $allowedFields = [
    'registration_number', 'invoice_id', 'amount', 'payment_method',
    'document_number', 'payment_date', 'receipt_file', 'status',
    'failure_reason', 'refund_date', 'refund_reason', 'notes'
];
```

**Recommendation:** Either:

1. Add `payment_number` field to the database schema
2. Generate it dynamically in the controller (e.g., `PAY-2026-0001`)

#### Issue 2: Missing Company Information

The receipt view expects `$company` array with address, email, and phone. This data is not being passed from the controller.

**Recommendation:** Define company information in a config file or environment variables.

---

## 3. Comparison with Invoice Print Functionality

### 3.1 Invoice Module Implementation (Working)

**Controller Method:** [`InvoiceController::downloadPdf($id)`](app/Modules/Payment/Controllers/InvoiceController.php:233)

```php
public function downloadPdf($id)
{
    $invoice = $this->invoiceModel->getInvoiceWithItems($id);
    if (!$invoice) {
        return redirect()->to('/invoice')->with('error', 'Invoice not found.');
    }

    $student = $this->admissionModel->select('...')
        ->join('profiles', 'profiles.id = admissions.profile_id')
        ->join('programs', 'programs.id = admissions.program_id')
        ->where('admissions.registration_number', (string)$invoice['registration_number'])
        ->first();

    return view('Modules\Payment\Views\invoices\print', [
        'invoice' => $invoice,
        'student' => $student
    ]);
}
```

**Route:** [`Routes.php:38`](app/Modules/Payment/Config/Routes.php:38)

```php
$routes->get('pdf/(:segment)', 'InvoiceController::downloadPdf/$1');
```

**View:** [`app/Modules/Payment/Views/invoices/print.php`](app/Modules/Payment/Views/invoices/print.php)

- Complete invoice layout
- Print button with `window.print()`
- QR code generation
- WhatsApp contact button
- Payment information footer

### 3.2 Key Differences

| Feature           | Invoice Print      | Payment Receipt         |
| ----------------- | ------------------ | ----------------------- |
| Controller Method | ✅ `downloadPdf()` | ❌ Missing              |
| Route             | ✅ Defined         | ❌ Missing              |
| Print Button      | ✅ In view         | ❌ Missing              |
| QR Code           | ✅ Implemented     | ✅ Implemented          |
| Company Info      | ✅ Hardcoded       | ❌ Expected as variable |
| Print Button      | ✅ Fixed position  | ❌ Not present          |
| WhatsApp Button   | ✅ Present         | ❌ Not present          |

---

## 4. Recommendations

### 4.1 Immediate Actions Required

#### 1. Add Receipt Controller Method

**File:** [`app/Modules/Payment/Controllers/PaymentController.php`](app/Modules/Payment/Controllers/PaymentController.php)

```php
/**
 * Display printable payment receipt
 */
public function receipt($id)
{
    $payment = $this->paymentModel->find($id);

    if (!$payment) {
        return redirect()->to('/payment')->with('error', 'Payment not found.');
    }

    // Get student details
    $student = $this->admissionModel->select('
            admissions.registration_number,
            profiles.full_name,
            profiles.email,
            profiles.phone,
            programs.title as program_title
        ')
        ->join('profiles', 'profiles.id = admissions.profile_id')
        ->join('programs', 'programs.id = admissions.program_id')
        ->where('admissions.registration_number', (string)$payment['registration_number'])
        ->first();

    // Get invoice details if linked
    $invoice = null;
    if ($payment['invoice_id']) {
        $invoice = $this->invoiceModel->find($payment['invoice_id']);
    }

    // Company information
    $company = [
        'address' => 'Perum GPR 1 Blok C No.4, Jl. Veteran Tulungrejo, Pare, Kediri 64212',
        'email' => 'admin@kursusbahasa.org',
        'phone' => '+62 858 1031 0950'
    ];

    // Generate payment number if not exists
    if (!isset($payment['payment_number'])) {
        $payment['payment_number'] = 'PAY-' . date('Y') . '-' . str_pad($payment['id'], 4, '0', STR_PAD_LEFT);
    }

    return view('Modules\Payment\Views\payments\receipt', [
        'payment' => $payment,
        'student' => $student,
        'invoice' => $invoice,
        'company' => $company
    ]);
}
```

#### 2. Add Receipt Route

**File:** [`app/Modules/Payment/Config/Routes.php`](app/Modules/Payment/Config/Routes.php)

Add to the payment routes group (after line 19):

```php
$routes->get('receipt/(:segment)', 'PaymentController::receipt/$1');
```

#### 3. Add Print Button to View

**File:** [`app/Modules/Payment/Views/payments/view.php`](app/Modules/Payment/Views/payments/view.php)

Add to the header buttons section (after line 22):

```php
<a href="<?= base_url('payment/receipt/' . $payment['id']) ?>"
   class="btn btn-light"
   target="_blank">
    <i class="bi bi-printer"></i> Print Receipt
</a>
```

#### 4. Add API Receipt Method

**File:** [`app/Modules/Payment/Controllers/Api/PaymentApiController.php`](app/Modules/Payment/Controllers/Api/PaymentApiController.php)

Add after the `uploadReceipt()` method:

```php
/**
 * Get payment receipt details
 * GET /api/payments/{id}/receipt
 */
public function getReceipt($id = null)
{
    $paymentModel = new PaymentModel();
    $admissionModel = new AdmissionModel();

    $payment = $paymentModel->find($id);

    if (!$payment) {
        return $this->failNotFound('Payment not found');
    }

    // Get student details
    $student = $admissionModel->select('
            admissions.registration_number,
            profiles.full_name,
            profiles.email,
            profiles.phone,
            programs.title as program_title
        ')
        ->join('profiles', 'profiles.id = admissions.profile_id')
        ->join('programs', 'programs.id = admissions.program_id')
        ->where('admissions.registration_number', (string)$payment['registration_number'])
        ->first();

    // Get invoice details if linked
    $invoice = null;
    if ($payment['invoice_id']) {
        $invoiceModel = new \Modules\Payment\Models\InvoiceModel();
        $invoice = $invoiceModel->find($payment['invoice_id']);
    }

    // Company information
    $company = [
        'address' => 'Perum GPR 1 Blok C No.4, Jl. Veteran Tulungrejo, Pare, Kediri 64212',
        'email' => 'admin@kursusbahasa.org',
        'phone' => '+62 858 1031 0950'
    ];

    // Generate payment number if not exists
    if (!isset($payment['payment_number'])) {
        $payment['payment_number'] = 'PAY-' . date('Y') . '-' . str_pad($payment['id'], 4, '0', STR_PAD_LEFT);
    }

    return $this->respond([
        'status' => 'success',
        'data' => [
            'payment' => $payment,
            'student' => $student,
            'invoice' => $invoice,
            'company' => $company
        ]
    ]);
}
```

### 4.2 Optional Enhancements

#### 1. Add Print Button to Receipt View

Add a floating print button similar to the invoice print view:

```html
<button class="print-button no-print" onclick="window.print()">
  🖨️ Print / Save as PDF
</button>
```

#### 2. Add WhatsApp Contact Button

Add a WhatsApp button for customer support:

```php
$waNumber = '6289509778659';
$message = "Hello Admin, I have a question about my payment #" . $payment['payment_number'];
$waUrl = "https://wa.me/" . $waNumber . "?text=" . urlencode($message);
```

#### 3. Add Payment Number to Database Schema

Consider adding a `payment_number` field to the payments table for better tracking:

```sql
ALTER TABLE payments ADD COLUMN payment_number VARCHAR(50) UNIQUE AFTER id;
```

#### 4. Create Company Configuration

Move company information to a config file:

```php
// app/Config/Company.php
<?php
namespace Config;

class Company
{
    public static $name = 'SOSCT';
    public static $fullName = 'SOS Course & Training';
    public static $address = 'Perum GPR 1 Blok C No.4, Jl. Veteran Tulungrejo, Pare, Kediri 64212';
    public static $email = 'admin@kursusbahasa.org';
    public static $phone = '+62 858 1031 0950';
}
```

---

## 5. Testing Checklist

After implementing the recommendations, verify:

- [x] Receipt page loads at `/payment/receipt/{id}`
- [x] All payment data displays correctly
- [x] Student information is populated
- [x] Invoice information shows when linked
- [x] QR code generates correctly
- [x] Print function works (Ctrl+P or button)
- [x] Print layout is clean and professional
- [x] API endpoint `/api/payments/{id}/receipt` returns correct data
- [x] Print button appears in payment view page
- [x] Receipt opens in new tab/window

---

## 6. Security Considerations

1. **Access Control:** Ensure receipt view requires authentication or uses secure tokens like the invoice module
2. **Data Validation:** Validate payment ID before displaying receipt
3. **XSS Prevention:** All output should use `esc()` function (already implemented)
4. **Rate Limiting:** Consider rate limiting for receipt generation to prevent abuse

---

## 7. Conclusion

The Payment Module has a well-designed receipt view template. All necessary controller methods, routes, and UI integration have been implemented to make it functional. The implementation follows the successful pattern used in the Invoice Module.

The receipt functionality is now **100% complete** - view, backend integration, routes, and UI buttons are all in place.

---

**Document Version:** 1.0  
**Date:** 2026-02-10  
**Analyzed By:** Kilo Code
