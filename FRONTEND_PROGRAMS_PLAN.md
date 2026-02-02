# Frontend Programs Feature - Implementation Plan

## Overview
Display all available programs on the frontend with detailed views and easy application process.

---

## User Flow

### 1. Programs Listing Page
**URL:** `/programs` or `/courses`

**Features:**
- Display all active programs as cards
- Show program thumbnail, title, category, fees
- Two buttons per card:
  - **"View Details"** - Go to program detail page
  - **"Apply Now"** - Go to application form with program pre-selected

**Layout:**
```
┌─────────────────────────────────────────┐
│  Our Programs                           │
│  ┌──────┐  ┌──────┐  ┌──────┐         │
│  │ IMG  │  │ IMG  │  │ IMG  │         │
│  │Title │  │Title │  │Title │         │
│  │Price │  │Price │  │Price │         │
│  │[Det] │  │[Det] │  │[Det] │         │
│  │[App] │  │[App] │  │[App] │         │
│  └──────┘  └──────┘  └──────┘         │
└─────────────────────────────────────────┘
```

### 2. Program Detail Page
**URL:** `/programs/{id}` or `/programs/{slug}`

**Features:**
- Full program information
- Large thumbnail image
- Description, features, facilities
- Pricing with discount calculation
- Two action buttons:
  - **"Apply for This Program"** - Go to application form
  - **"Ask Admin via WhatsApp"** - Open WhatsApp with pre-filled message

**Layout:**
```
┌─────────────────────────────────────────┐
│  ← Back to Programs                     │
│  ┌──────────┐  Program Title            │
│  │          │  Category: Technology     │
│  │  Image   │  Price: Rp 5.000.000     │
│  │          │  Discount: 10%            │
│  └──────────┘  Final: Rp 4.500.000     │
│                                          │
│  Description                             │
│  Lorem ipsum dolor sit amet...          │
│                                          │
│  Features        Facilities              │
│  • Feature 1     • Facility 1           │
│  • Feature 2     • Facility 2           │
│                                          │
│  [Apply for This Program]               │
│  [Ask Admin via WhatsApp]               │
└─────────────────────────────────────────┘
```

### 3. Application Form (Enhanced)
**URL:** `/apply?program={id}` or `/apply/{program-id}`

**Features:**
- Pre-fill course field with selected program
- Course field becomes read-only (or hidden with hidden input)
- Show selected program info at top of form
- All other fields remain the same

**Layout:**
```
┌─────────────────────────────────────────┐
│  Apply for Admission                    │
│  ┌─────────────────────────────────┐   │
│  │ Applying for: Computer Science  │   │
│  │ Fee: Rp 5.000.000 (10% off)    │   │
│  └─────────────────────────────────┘   │
│                                          │
│  [Personal Information Form]            │
│  [Contact Information Form]             │
│  ...                                     │
│  Course: Computer Science (read-only)   │
│  ...                                     │
│  [Submit Application]                   │
└─────────────────────────────────────────┘
```

---

## Technical Implementation

### 1. Routes to Add

**File:** `app/Modules/Frontend/Config/Routes.php`

```php
// Programs listing
$routes->get('programs', 'PageController::programs');

// Program detail
$routes->get('programs/(:segment)', 'PageController::programDetail/$1');

// Apply with program pre-selected
$routes->get('apply/(:segment)', 'PageController::applyWithProgram/$1');
```

### 2. Controller Methods to Add

**File:** `app/Modules/Frontend/Controllers/PageController.php`

#### Method 1: `programs()`
```php
public function programs()
{
    $programModel = new \Modules\Program\Models\ProgramModel();
    $programs = $programModel->getActivePrograms();
    
    return view('Modules\Frontend\Views\programs', [
        'title' => 'Our Programs',
        'programs' => $programs
    ]);
}
```

#### Method 2: `programDetail($id)`
```php
public function programDetail($id)
{
    $programModel = new \Modules\Program\Models\ProgramModel();
    $program = $programModel->find($id);
    
    if (!$program || $program['status'] !== 'active') {
        return redirect()->to('/programs')
            ->with('error', 'Program not found');
    }
    
    // Calculate final price with discount
    $finalPrice = $program['tuition_fee'] * (1 - $program['discount'] / 100);
    
    return view('Modules\Frontend\Views\program_detail', [
        'title' => $program['title'],
        'program' => $program,
        'finalPrice' => $finalPrice
    ]);
}
```

#### Method 3: `applyWithProgram($programId)`
```php
public function applyWithProgram($programId)
{
    $programModel = new \Modules\Program\Models\ProgramModel();
    $program = $programModel->find($programId);
    
    if (!$program || $program['status'] !== 'active') {
        return redirect()->to('/programs')
            ->with('error', 'Program not found');
    }
    
    // Get all programs for dropdown (in case user wants to change)
    $programs = $programModel->getActivePrograms();
    
    return view('Modules\Frontend\Views\apply', [
        'title' => 'Apply for Admission',
        'programs' => $programs,
        'selectedProgram' => $program
    ]);
}
```

#### Method 4: Update `apply()` to handle optional program
```php
public function apply()
{
    $programModel = new \Modules\Program\Models\ProgramModel();
    $programs = $programModel->getActivePrograms();
    
    return view('Modules\Frontend\Views\apply', [
        'title' => 'Apply for Admission',
        'programs' => $programs,
        'selectedProgram' => null // No pre-selection
    ]);
}
```

### 3. Views to Create

#### View 1: Programs Listing
**File:** `app/Modules/Frontend/Views/programs.php`

**Features:**
- Grid layout (3-4 cards per row)
- Program cards with:
  - Thumbnail image
  - Title
  - Category badge
  - Short description (truncated)
  - Price with discount
  - "View Details" button
  - "Apply Now" button
- Filter by category (optional)
- Search functionality (optional)

#### View 2: Program Detail
**File:** `app/Modules/Frontend/Views/program_detail.php`

**Features:**
- Large hero image
- Full program information
- Features list
- Facilities list
- Pricing breakdown
- "Apply for This Program" button
- "Ask Admin via WhatsApp" button with pre-filled message

**WhatsApp Link Format:**
```php
$waNumber = '6281234567890'; // Admin WhatsApp number
$message = urlencode("Hello, I'm interested in the {$program['title']} program. Can you provide more information?");
$waLink = "https://wa.me/{$waNumber}?text={$message}";
```

#### View 3: Enhanced Apply Form
**File:** `app/Modules/Frontend/Views/apply.php` (update existing)

**Changes:**
- Add program info banner at top (if program is pre-selected)
- Make course field read-only if program is pre-selected
- Or use hidden input + display field
- Highlight selected program in dropdown

### 4. Database Considerations

**No schema changes needed!** We'll use existing:
- `programs` table - Already has all needed fields
- `admissions` table - Already has `course` field

### 5. Configuration

**Add to `.env` or config:**
```env
# WhatsApp Admin Contact
app.adminWhatsApp = '6281234567890'
```

**Or in `app/Config/App.php`:**
```php
public string $adminWhatsApp = '6281234567890';
```

---

## UI/UX Enhancements

### Program Card Design
```html
<div class="program-card">
    <img src="thumbnail" alt="Program">
    <span class="badge">Category</span>
    <h3>Program Title</h3>
    <p class="description">Short description...</p>
    <div class="pricing">
        <span class="original">Rp 5.000.000</span>
        <span class="discount">10% OFF</span>
        <span class="final">Rp 4.500.000</span>
    </div>
    <div class="actions">
        <a href="/programs/{id}" class="btn-detail">View Details</a>
        <a href="/apply/{id}" class="btn-apply">Apply Now</a>
    </div>
</div>
```

### Program Detail Layout
- Breadcrumb navigation
- Sticky "Apply" button on scroll
- Image gallery (if multiple images in future)
- Related programs section (optional)
- Testimonials section (optional)

### Apply Form Enhancements
- Progress indicator (Step 1 of 5)
- Save draft functionality (optional)
- Form validation with helpful messages
- Success page with application number

---

## Features Breakdown

### Must Have (MVP)
1. ✅ Programs listing page
2. ✅ Program detail page
3. ✅ Apply with pre-selected program
4. ✅ WhatsApp contact button
5. ✅ Responsive design

### Nice to Have (Phase 2)
1. ⭐ Category filter on listing
2. ⭐ Search functionality
3. ⭐ Program comparison feature
4. ⭐ Save favorite programs
5. ⭐ Share program via social media
6. ⭐ Print program details
7. ⭐ Related programs suggestions

### Future Enhancements (Phase 3)
1. 🚀 Program reviews/ratings
2. 🚀 Virtual tour/video
3. 🚀 Live chat with admin
4. 🚀 Application status tracking
5. 🚀 Email notifications
6. 🚀 Multiple language support

---

## URL Structure

### Option 1: ID-based (Simple)
```
/programs                    - List all programs
/programs/123                - Program detail
/apply/123                   - Apply for program 123
```

### Option 2: Slug-based (SEO-friendly) ⭐ Recommended
```
/programs                           - List all programs
/programs/computer-science          - Program detail
/apply/computer-science             - Apply for program
```

**Benefits of slugs:**
- Better SEO
- More readable URLs
- Easier to share

**Implementation:**
- Add `slug` field to programs table (optional)
- Or generate slug from title on-the-fly

---

## WhatsApp Integration

### Message Templates

**From Program Detail:**
```
Hello, I'm interested in the [Program Name] program.

Program Details:
- Category: [Category]
- Fee: Rp [Price]

Can you provide more information about:
- Admission requirements
- Class schedule
- Payment options

Thank you!
```

**From Apply Form:**
```
Hello, I have submitted an application for [Program Name].

Application Number: [REG-NUMBER]
Name: [Full Name]
Email: [Email]

Please confirm receipt of my application.

Thank you!
```

### Configuration
```php
// In controller or helper
$adminWA = config('App')->adminWhatsApp;
$message = "Hello, I'm interested in {$program['title']}...";
$waLink = "https://wa.me/{$adminWA}?text=" . urlencode($message);
```

---

## Implementation Steps

### Phase 1: Basic Functionality (Day 1)
1. Create routes
2. Add controller methods
3. Create programs listing view
4. Create program detail view
5. Update apply form to handle pre-selection

### Phase 2: Enhancements (Day 2)
1. Add WhatsApp integration
2. Improve styling and responsiveness
3. Add breadcrumb navigation
4. Add program info banner on apply form
5. Test all flows

### Phase 3: Polish (Day 3)
1. Add category filter
2. Add search functionality
3. Optimize images
4. Add loading states
5. Add error handling
6. Test on mobile devices

---

## Testing Checklist

### Functionality
- [ ] Programs listing displays all active programs
- [ ] Program cards show correct information
- [ ] "View Details" button works
- [ ] "Apply Now" button works
- [ ] Program detail page displays correctly
- [ ] WhatsApp button opens with correct message
- [ ] Apply form pre-fills selected program
- [ ] Course field is read-only when pre-selected
- [ ] Application submits successfully
- [ ] Inactive programs don't show on frontend

### UI/UX
- [ ] Responsive on mobile
- [ ] Responsive on tablet
- [ ] Images load correctly
- [ ] Buttons are clickable
- [ ] Navigation is intuitive
- [ ] Loading states work
- [ ] Error messages are clear

### Edge Cases
- [ ] No programs available
- [ ] Program not found (404)
- [ ] Invalid program ID
- [ ] Inactive program accessed directly
- [ ] Apply without selecting program
- [ ] Network errors handled gracefully

---

## File Structure

```
app/Modules/Frontend/
├── Config/
│   └── Routes.php (update)
├── Controllers/
│   └── PageController.php (update)
└── Views/
    ├── programs.php (new)
    ├── program_detail.php (new)
    ├── apply.php (update)
    └── layout.php (existing)
```

---

## Summary

This plan provides:
1. **Clear user flow** - Browse → Detail → Apply
2. **Easy application** - Pre-selected program
3. **Direct contact** - WhatsApp integration
4. **Scalable design** - Room for future features
5. **SEO-friendly** - Clean URLs and structure

**Estimated Time:**
- Planning: ✅ Done
- Implementation: 6-8 hours
- Testing: 2-3 hours
- **Total: 1-2 days**

Ready to implement? 🚀
