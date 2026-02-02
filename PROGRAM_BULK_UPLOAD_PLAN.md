# Program Bulk Upload Feature - Implementation Plan

## Overview
Add bulk upload functionality to the Program module, allowing admins to upload an Excel file containing multiple programs at once. This will include a downloadable Excel template and validation for the uploaded data.

---

## Feature Requirements

### 1. User Interface Changes
**Location**: `app/Modules/Program/Views/index.php`

- Add a "Bulk Upload" button next to the "Add New Program" button
- Button should open a modal dialog for file upload
- Modal should contain:
  - File upload input (accept only .xlsx, .xls files)
  - "Download Template" link to get the Excel template
  - Upload button
  - Instructions/help text about the format

### 2. Excel Template
**Location**: `public/templates/program_bulk_upload_template.xlsx`

**Template Structure** (Columns):
1. **title** (Required) - Program title
2. **description** (Optional) - Program description
3. **category** (Optional) - Program category
4. **sub_category** (Optional) - Program sub-category
5. **registration_fee** (Optional) - Registration fee (numeric, default: 0)
6. **tuition_fee** (Optional) - Tuition fee (numeric, default: 0)
7. **discount** (Optional) - Discount percentage (0-100, default: 0)
8. **status** (Required) - Status (active/inactive, default: active)
9. **features** (Optional) - Features (pipe-separated: Feature 1|Feature 2|Feature 3)
10. **facilities** (Optional) - Facilities (pipe-separated: Facility 1|Facility 2)
11. **extra_facilities** (Optional) - Extra facilities (pipe-separated: Extra 1|Extra 2)

**Template Features**:
- First row: Column headers with clear labels
- Second row: Example data showing correct format
- Third row: Data type hints/validation rules as comments
- Include instructions sheet explaining each field

### 3. Backend Implementation

#### 3.1 Controller Method
**Location**: `app/Modules/Program/Controllers/ProgramController.php`

**New Methods**:
- `downloadTemplate()` - Download the Excel template file
- `bulkUpload()` - Handle the bulk upload process
- `processBulkData()` - Process and validate Excel data

**Validation Rules**:
- File must be .xlsx or .xls format
- File size limit: 5MB
- Required fields: title, status
- Status must be 'active' or 'inactive'
- Discount must be between 0-100
- Fees must be numeric and >= 0
- Pipe-separated fields (features, facilities) must be properly formatted

#### 3.2 Excel Processing Library
**Library**: PhpSpreadsheet (already available in CodeIgniter 4)

**Installation** (if not present):
```bash
composer require phpoffice/phpspreadsheet
```

#### 3.3 Processing Logic
1. **Upload & Validation**:
   - Validate file type and size
   - Check if file is readable
   - Validate Excel structure (correct columns)

2. **Data Extraction**:
   - Read Excel rows (skip header row)
   - Extract data from each column
   - Convert pipe-separated values to arrays

3. **Data Validation**:
   - Validate each row against model rules
   - Collect validation errors with row numbers
   - Check for duplicate titles in the upload

4. **Database Insert**:
   - Use batch insert for performance
   - Generate UUIDs for each program
   - Handle JSON encoding for array fields
   - Set timestamps

5. **Response**:
   - Success: Show count of imported programs
   - Partial Success: Show imported count + error list
   - Failure: Show all validation errors with row numbers

### 4. Routes
**Location**: `app/Modules/Program/Config/Routes.php`

Add new routes:
```php
$routes->get('program/download-template', 'ProgramController::downloadTemplate');
$routes->post('program/bulk-upload', 'ProgramController::bulkUpload');
```

### 5. Error Handling

**Error Types**:
- Invalid file format
- File too large
- Missing required columns
- Invalid data in rows (with row number)
- Duplicate titles
- Database insertion errors

**Error Display**:
- Show errors in a dismissible alert
- List errors by row number for easy correction
- Provide option to download error report

### 6. Success Feedback

**Success Message**:
- "Successfully imported X programs"
- Show summary: Total rows, Successful, Failed
- Option to view imported programs

---

## Implementation Steps

### Phase 1: Template Creation
1. Create Excel template with proper structure
2. Add example data and instructions
3. Save template in `public/templates/` directory
4. Create download route and method

### Phase 2: UI Updates
1. Add "Bulk Upload" button to index page
2. Create modal dialog with file upload form
3. Add "Download Template" link in modal
4. Style modal to match existing design

### Phase 3: Backend Processing
1. Install PhpSpreadsheet library (if needed)
2. Create `bulkUpload()` method in controller
3. Implement Excel file reading logic
4. Add data validation logic
5. Implement batch insert to database
6. Add error handling and reporting

### Phase 4: Testing
1. Test with valid Excel file
2. Test with invalid file formats
3. Test with missing required fields
4. Test with invalid data types
5. Test with large files (performance)
6. Test with duplicate titles
7. Test error reporting

### Phase 5: Documentation
1. Add user guide for bulk upload
2. Document Excel template format
3. Add inline help text in modal

---

## Technical Considerations

### Performance
- Use batch insert for multiple records
- Limit file size to prevent memory issues
- Process in chunks if file is very large (>1000 rows)
- Show progress indicator for large uploads

### Security
- Validate file type (MIME type check)
- Sanitize all input data
- Prevent SQL injection via prepared statements
- Limit file upload size
- Check user permissions (program.manage)

### Data Integrity
- Validate all data before insertion
- Use database transactions (rollback on error)
- Generate unique UUIDs for each program
- Handle duplicate titles gracefully

### User Experience
- Clear instructions in modal
- Helpful error messages with row numbers
- Download template easily accessible
- Show upload progress
- Provide success/error summary

---

## File Structure

```
app/Modules/Program/
├── Controllers/
│   └── ProgramController.php (add new methods)
├── Views/
│   └── index.php (add bulk upload button & modal)
└── Config/
    └── Routes.php (add new routes)

public/
└── templates/
    └── program_bulk_upload_template.xlsx (new file)
```

---

## Dependencies

- **PhpSpreadsheet**: For Excel file processing
  ```bash
  composer require phpoffice/phpspreadsheet
  ```

---

## Permissions

- Bulk upload should require `program.manage` permission
- Only users with this permission can see the bulk upload button
- Template download can be public or restricted (decide based on requirements)

---

## Future Enhancements (Optional)

1. **Image Upload**: Support thumbnail upload via ZIP file
2. **Update Mode**: Allow bulk update of existing programs
3. **Export**: Export current programs to Excel
4. **Validation Preview**: Show preview before final import
5. **Async Processing**: Use queue for very large files
6. **Import History**: Track bulk upload history with user and timestamp

---

## Estimated Effort

- **Template Creation**: 1 hour
- **UI Implementation**: 2 hours
- **Backend Logic**: 4 hours
- **Testing**: 2 hours
- **Documentation**: 1 hour

**Total**: ~10 hours

---

## Notes

- The template should be user-friendly with clear examples
- Error messages should be specific and actionable
- Consider adding a "dry run" mode to validate without importing
- Keep the UI consistent with existing program management interface
