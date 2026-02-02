# Program Bulk Upload - Quick Reference

## 🚀 Quick Start

1. **Access**: Go to `/program` → Click "Bulk Upload"
2. **Download**: Click "Download Excel Template"
3. **Fill**: Add your programs starting from row 4
4. **Upload**: Select file and click "Upload & Import"

## 📋 Template Columns

| Column | Required | Type | Example |
|--------|----------|------|---------|
| title | ✅ Yes | Text | "Computer Science Program" |
| description | ❌ No | Text | "A comprehensive CS program" |
| category | ❌ No | Text | "Technology" |
| sub_category | ❌ No | Text | "Computer Science" |
| registration_fee | ❌ No | Number | 500000 |
| tuition_fee | ❌ No | Number | 5000000 |
| discount | ❌ No | Number (0-100) | 10 |
| status | ✅ Yes | Text | "active" or "inactive" |
| features | ❌ No | Pipe-separated | "Programming\|Web Dev\|Database" |
| facilities | ❌ No | Pipe-separated | "Lab\|Library\|Study Room" |
| extra_facilities | ❌ No | Pipe-separated | "Online Platform\|Career Help" |

## ✅ Validation Rules

- **Title**: Cannot be empty
- **Status**: Must be "active" or "inactive" (lowercase)
- **Fees**: Must be 0 or positive numbers
- **Discount**: Must be between 0 and 100
- **File**: .xlsx or .xls, max 5MB

## 🎯 Pipe-Separated Format

Use the pipe character `|` to separate multiple items:

```
Good: Item 1|Item 2|Item 3
Bad:  Item 1, Item 2, Item 3
Bad:  Item 1; Item 2; Item 3
```

## ⚠️ Common Mistakes

1. ❌ Modifying column headers
2. ❌ Using commas instead of pipes
3. ❌ Adding currency symbols (Rp, $)
4. ❌ Using "Active" instead of "active"
5. ❌ Leaving title empty
6. ❌ Negative fees or discount > 100

## 💡 Tips

- Test with 2-3 rows first
- Keep the example row for reference
- Don't delete row 1 (headers)
- Save file before uploading
- Check error messages for row numbers

## 🔐 Permissions

- Requires: `program.manage` permission
- Only authorized admins can bulk upload

## 📞 Support

See `PROGRAM_BULK_UPLOAD_GUIDE.md` for detailed instructions.
