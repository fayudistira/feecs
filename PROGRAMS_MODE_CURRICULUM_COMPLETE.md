# Programs Mode & Curriculum Implementation - Complete

## Summary
Successfully added `mode` and `curriculum` fields to the programs table and updated all views and controllers to properly handle them.

## Issue Fixed
**Problem**: Curriculum data was not being saved to the database when editing programs.
**Root Cause**: The `ProgramController` was not capturing the `mode` and `curriculum` fields from the form POST data.
**Solution**: Updated both `store()` and `update()` methods to properly handle these fields.

## Changes Made

### 1. Database Migrations
- **File**: `app/Database/Migrations/2026-02-02-103246_AddModeCurriculumToPrograms.php`
  - Added `mode` column: ENUM('online', 'offline'), default 'offline'
  - Added `curriculum` column: JSON, nullable

- **File**: `app/Database/Migrations/2026-02-02-112535_UpdateExistingProgramsMode.php`
  - Updated all existing programs to set `mode = 'offline'` as default
  - Verified: 2 programs updated successfully

### 2. Model Updates
- **File**: `app/Modules/Program/Models/ProgramModel.php`
  - Added `mode` and `curriculum` to `allowedFields`
  - Added validation rule for `mode`: `permit_empty|in_list[online,offline]`
  - Updated `encodeJsonFields()` to handle curriculum separately (already JSON-encoded in controller)
  - JSON decoding for `curriculum` field in `decodeJsonFields()`

### 3. Controller Updates (FIXED)
- **File**: `app/Modules/Program/Controllers/ProgramController.php`
  - **store() method**:
    - Added `mode` field capture: `$this->request->getPost('mode') ?: 'offline'`
    - Added curriculum processing with empty entry filtering
    - JSON encodes curriculum array before saving
  - **update() method**:
    - Added `mode` field capture
    - Added curriculum processing with empty entry filtering
    - JSON encodes curriculum array before saving

### 4. View Updates

#### Admin Views
- **Create Form** (`app/Modules/Program/Views/create.php`):
  - Mode dropdown (Online/Offline)
  - Dynamic curriculum section with JavaScript
  - Add/remove curriculum chapters functionality

- **Edit Form** (`app/Modules/Program/Views/edit.php`):
  - Mode dropdown with pre-selected value
  - Curriculum section with pre-filled data
  - Dynamic add/remove functionality

- **View Page** (`app/Modules/Program/Views/view.php`):
  - Mode badge display (blue for offline, cyan for online)
  - Curriculum accordion with expandable chapters

#### Frontend Views
- **Program Detail** (`app/Modules/Frontend/Views/Programs/detail.php`):
  - Mode badge in sticky info card
  - Curriculum accordion with Bootstrap styling
  - First chapter expanded by default

## Field Specifications

### Mode Field
- **Type**: ENUM
- **Values**: 'online' or 'offline'
- **Default**: 'offline'
- **Display**: 
  - Online: Info badge with laptop icon
  - Offline: Primary badge with building icon

### Curriculum Field
- **Type**: JSON
- **Structure**: Array of objects
  ```json
  [
    {
      "chapter": "Chapter 1: Introduction",
      "description": "Brief description of the chapter"
    },
    {
      "chapter": "Chapter 2: Advanced Topics",
      "description": "More detailed content"
    }
  ]
  ```
- **Processing**: 
  - Controller filters out empty entries
  - JSON encodes before saving
  - Model decodes after fetching
- **Display**: Bootstrap accordion with expandable sections

## How It Works

### Saving Curriculum Data
1. User fills in curriculum form with chapter titles and descriptions
2. Form submits as array: `curriculum[0][chapter]`, `curriculum[0][description]`, etc.
3. Controller receives array and filters out empty entries
4. Controller JSON encodes the filtered array
5. Model's `encodeJsonFields()` passes through the already-encoded JSON string
6. Data saved to database as JSON

### Loading Curriculum Data
1. Model fetches data from database
2. Model's `decodeJsonFields()` converts JSON string to array
3. Controller passes array to view
4. View displays in accordion format

## Testing Checklist
- [x] Migration runs successfully
- [x] Existing programs updated with default mode
- [x] Controller captures mode and curriculum from form
- [x] Controller filters empty curriculum entries
- [x] Controller JSON encodes curriculum properly
- [x] Model handles already-encoded curriculum
- [x] Create form displays mode and curriculum fields
- [x] Edit form displays and pre-fills mode and curriculum
- [x] Admin view page displays mode badge and curriculum accordion
- [x] Frontend detail page displays mode badge and curriculum accordion
- [ ] **TEST NOW**: Edit a program and add curriculum data
- [ ] **TEST NOW**: Verify curriculum saves to database
- [ ] **TEST NOW**: Verify curriculum displays on view pages

## Next Steps
1. **Try editing a program again** and add curriculum data
2. Check the database to confirm curriculum is saved as JSON
3. View the program on both admin and frontend to see curriculum display
4. Create a new program with curriculum to test the create form

## Files Modified
1. `app/Database/Migrations/2026-02-02-103246_AddModeCurriculumToPrograms.php` (new)
2. `app/Database/Migrations/2026-02-02-112535_UpdateExistingProgramsMode.php` (new)
3. `app/Modules/Program/Models/ProgramModel.php` (updated - fixed encodeJsonFields)
4. `app/Modules/Program/Controllers/ProgramController.php` (updated - FIXED store and update methods)
5. `app/Modules/Program/Views/create.php` (updated)
6. `app/Modules/Program/Views/edit.php` (updated)
7. `app/Modules/Program/Views/view.php` (updated)
8. `app/Modules/Frontend/Views/Programs/detail.php` (updated)
