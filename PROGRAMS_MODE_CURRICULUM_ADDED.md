# Programs Mode & Curriculum Columns - Added ✓

## Overview
Added two new columns to the programs table:
1. **mode** - ENUM field for online/offline delivery
2. **curriculum** - JSON field for storing course chapters

## Database Changes

### Migration Created
**File**: `app/Database/Migrations/2026-02-02-103246_AddModeCurriculumToPrograms.php`

### Columns Added

#### 1. Mode Column
```sql
Column: mode
Type: ENUM('online', 'offline')
Default: 'offline'
Null: NOT NULL
Position: After 'status'
```

**Purpose**: Indicates whether the program is delivered online or offline (in-person)

**Values**:
- `online` - Program delivered remotely via internet
- `offline` - Program delivered in-person at physical location

#### 2. Curriculum Column
```sql
Column: curriculum
Type: JSON
Default: NULL
Null: NULLABLE
Position: After 'mode'
```

**Purpose**: Stores structured curriculum data with chapters and descriptions

**Structure**:
```json
[
    {
        "chapter": "Chapter 1: Introduction",
        "description": "Overview of the course and learning objectives"
    },
    {
        "chapter": "Chapter 2: Fundamentals",
        "description": "Core concepts and basic principles"
    },
    ...
]
```

## Model Updates

### ProgramModel Changes
**File**: `app/Modules/Program/Models/ProgramModel.php`

#### 1. Added to Allowed Fields
```php
protected $allowedFields = [
    // ... existing fields
    'mode',
    'curriculum'
];
```

#### 2. Added Validation Rule
```php
protected $validationRules = [
    // ... existing rules
    'mode' => 'permit_empty|in_list[online,offline]'
];
```

#### 3. Updated JSON Encoding/Decoding
- Added `curriculum` to JSON fields array
- Special handling for curriculum field
- Automatically encodes/decodes on save/fetch

**Encode Logic**:
```php
- If string: Try to decode as JSON, validate, re-encode
- If array: Encode to JSON
- If invalid: Store empty array
```

**Decode Logic**:
```php
- Automatically decodes JSON to array on fetch
- Returns empty array if invalid JSON
```

## Table Structure

### Before (16 fields):
1. id
2. title
3. description
4. thumbnail
5. features (JSON)
6. facilities (JSON)
7. extra_facilities (JSON)
8. registration_fee
9. tuition_fee
10. discount
11. category
12. sub_category
13. status
14. created_at
15. updated_at
16. deleted_at

### After (18 fields):
1-14. (same as before)
15. **mode** (NEW)
16. **curriculum** (NEW)
17. created_at
18. updated_at
19. deleted_at

## Usage Examples

### Creating Program with New Fields

```php
$programModel = new ProgramModel();

$data = [
    'title' => 'Web Development Bootcamp',
    'mode' => 'online',
    'curriculum' => [
        [
            'chapter' => 'Week 1: HTML & CSS Basics',
            'description' => 'Learn the fundamentals of web structure and styling'
        ],
        [
            'chapter' => 'Week 2: JavaScript Fundamentals',
            'description' => 'Introduction to programming with JavaScript'
        ],
        [
            'chapter' => 'Week 3: React Framework',
            'description' => 'Building modern web applications with React'
        ]
    ],
    // ... other fields
];

$programModel->save($data);
```

### Fetching Program

```php
$program = $programModel->find($id);

// Access mode
echo $program['mode']; // 'online' or 'offline'

// Access curriculum (automatically decoded to array)
foreach ($program['curriculum'] as $chapter) {
    echo $chapter['chapter'];
    echo $chapter['description'];
}
```

### Updating Curriculum

```php
$programModel->update($id, [
    'curriculum' => [
        [
            'chapter' => 'Module 1: Getting Started',
            'description' => 'Introduction and setup'
        ],
        // ... more chapters
    ]
]);
```

## Frontend Display (Future Enhancement)

### Mode Badge
```php
<?php if ($program['mode'] === 'online'): ?>
    <span class="badge bg-info">
        <i class="bi bi-laptop"></i> Online
    </span>
<?php else: ?>
    <span class="badge bg-primary">
        <i class="bi bi-building"></i> Offline
    </span>
<?php endif ?>
```

### Curriculum Display
```php
<?php if (!empty($program['curriculum'])): ?>
    <div class="curriculum-section">
        <h5>Course Curriculum</h5>
        <div class="accordion">
            <?php foreach ($program['curriculum'] as $index => $chapter): ?>
                <div class="accordion-item">
                    <h6><?= esc($chapter['chapter']) ?></h6>
                    <p><?= esc($chapter['description']) ?></p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>
```

## API Response Example

```json
{
    "id": "uuid-here",
    "title": "Web Development Bootcamp",
    "mode": "online",
    "curriculum": [
        {
            "chapter": "Week 1: HTML & CSS Basics",
            "description": "Learn the fundamentals of web structure and styling"
        },
        {
            "chapter": "Week 2: JavaScript Fundamentals",
            "description": "Introduction to programming with JavaScript"
        }
    ],
    "category": "Technology",
    "tuition_fee": 5000000,
    ...
}
```

## Benefits

### Mode Field:
1. **Clear Delivery Method**: Users know if program is online or in-person
2. **Filtering**: Can filter programs by delivery mode
3. **Scheduling**: Different scheduling for online vs offline
4. **Resources**: Different resource requirements

### Curriculum Field:
1. **Structured Content**: Organized chapter-by-chapter breakdown
2. **Transparency**: Students see what they'll learn
3. **Flexibility**: Easy to add/remove/reorder chapters
4. **Searchable**: Can search within curriculum content
5. **Expandable**: Can add more fields (duration, resources, etc.)

## Migration Commands

### Run Migration:
```bash
php spark migrate
```

### Rollback (if needed):
```bash
php spark migrate:rollback
```

### Check Status:
```bash
php spark migrate:status
```

## Testing

### Verify Columns Exist:
```bash
php spark db:table programs --show
```

### Test Insert:
```php
$programModel->save([
    'title' => 'Test Program',
    'mode' => 'online',
    'curriculum' => [
        ['chapter' => 'Test', 'description' => 'Test desc']
    ]
]);
```

### Test Fetch:
```php
$program = $programModel->find($id);
var_dump($program['mode']); // string
var_dump($program['curriculum']); // array
```

## Validation

### Mode Validation:
- Must be either 'online' or 'offline'
- Defaults to 'offline' if not provided
- Cannot be null

### Curriculum Validation:
- Must be valid JSON
- Can be null (optional field)
- Automatically decoded to array
- Empty array if invalid

## Database Compatibility
- ✓ MySQL 5.7+ (JSON support)
- ✓ MariaDB 10.2+ (JSON support)
- ✓ PostgreSQL (JSONB support)

## Status: ✓ COMPLETE
- Migration created and run successfully
- Model updated with new fields
- Validation rules added
- JSON encoding/decoding configured
- Table now has 18 fields (was 16)
- Ready for use in controllers and views

## Next Steps (Optional)
1. Update program create/edit forms to include mode and curriculum
2. Display mode badge on program cards
3. Show curriculum on program detail page
4. Add curriculum accordion/tabs
5. Update bulk upload template to include new fields
6. Add filtering by mode (online/offline)
