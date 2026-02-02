# Program Bulk Upload Guide

## Overview
The bulk upload feature allows administrators to import multiple programs at once using an Excel file. This is useful when you need to add many programs quickly.

## How to Use

### Step 1: Download the Template
1. Go to the Programs page (`/program`)
2. Click the "Bulk Upload" button
3. In the modal dialog, click "Download Excel Template"
4. Save the template file to your computer

### Step 2: Fill in Your Data
1. Open the downloaded template in Excel or any spreadsheet application
2. The template has two sheets:
   - **Programs**: Where you enter your data
   - **Instructions**: Detailed guide on how to fill the template

3. Starting from row 4, enter your program data:
   - Row 1: Column headers (DO NOT MODIFY)
   - Row 2: Example data (you can delete or replace)
   - Row 3: Field descriptions (for reference)
   - Row 4+: Your program data

### Step 3: Field Descriptions

#### Required Fields
- **title**: Program name (e.g., "Computer Science Program")
- **status**: Must be either "active" or "inactive"

#### Optional Fields
- **description**: Detailed description of the program
- **category**: Main category (e.g., "Technology", "Business", "Arts")
- **sub_category**: More specific classification
- **registration_fee**: One-time registration fee (numbers only, no currency symbols)
- **tuition_fee**: Tuition fee per period (numbers only)
- **discount**: Discount percentage (0-100)
- **features**: Program features separated by pipe `|`
  - Example: `Programming|Web Development|Database Design`
- **facilities**: Available facilities separated by pipe `|`
  - Example: `Computer Lab|Library|Study Room`
- **extra_facilities**: Additional facilities separated by pipe `|`
  - Example: `Online Learning Platform|Career Counseling`

### Step 4: Upload the File
1. Save your Excel file
2. Go back to the Programs page
3. Click "Bulk Upload" button
4. Click "Choose File" and select your filled template
5. Click "Upload & Import"

### Step 5: Review Results
After upload, you'll see one of these messages:
- **Success**: All programs imported successfully
- **Partial Success**: Some programs imported, some had errors (errors will be listed)
- **Error**: No programs imported (all rows had errors)

## Important Notes

### File Requirements
- File format: `.xlsx` or `.xls`
- Maximum file size: 5MB
- Must use the provided template structure

### Data Validation
- Title cannot be empty
- Status must be "active" or "inactive"
- Discount must be between 0 and 100
- Fees cannot be negative
- Pipe-separated fields should use `|` (pipe character)

### Common Errors and Solutions

**Error: "Title is required"**
- Solution: Make sure the title column is not empty

**Error: "Status must be 'active' or 'inactive'"**
- Solution: Check the status column - it should only contain "active" or "inactive" (lowercase)

**Error: "Discount must be between 0 and 100"**
- Solution: Ensure discount values are numbers between 0 and 100

**Error: "Fees cannot be negative"**
- Solution: Registration fee and tuition fee must be 0 or positive numbers

**Error: "Invalid template format"**
- Solution: Download a fresh template and don't modify the column headers

### Tips for Success
1. Use the example row as a guide
2. Don't modify column headers in row 1
3. Remove the example data row before uploading (or replace with your data)
4. For numeric fields, enter numbers only (no currency symbols or commas)
5. For pipe-separated fields, use the pipe character `|` without spaces
6. Save your file before uploading
7. If you have many programs, test with a few rows first

## Example Data

Here's an example of properly formatted data:

| title | description | category | sub_category | registration_fee | tuition_fee | discount | status | features | facilities | extra_facilities |
|-------|-------------|----------|--------------|------------------|-------------|----------|--------|----------|------------|------------------|
| Computer Science | Comprehensive CS program | Technology | Computer Science | 500000 | 5000000 | 10 | active | Programming\|Web Dev\|Database | Computer Lab\|Library | Online Platform\|Career Help |
| Business Management | MBA program | Business | Management | 750000 | 8000000 | 15 | active | Leadership\|Finance\|Marketing | Meeting Rooms\|Library | Networking Events |

## Troubleshooting

**Upload button is disabled**
- Make sure you've selected a file
- Check that the file is .xlsx or .xls format

**"File upload failed"**
- Check file size (must be under 5MB)
- Try saving the file again
- Make sure the file isn't corrupted

**All rows show errors**
- Verify you're using the correct template
- Check that column headers match exactly
- Ensure required fields are filled

## Need Help?
If you encounter issues not covered in this guide, contact your system administrator.
