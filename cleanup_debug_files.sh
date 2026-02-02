#!/bin/bash
# Cleanup script - Remove all debug/test files

echo "Cleaning up debug and test files..."

# Remove debug files from public directory
rm -f public/test_image.php
rm -f public/debug_thumbnails.php
rm -f public/check_uploads.php

# Remove test files from root
rm -f test_route.php
rm -f debug_thumbnails.php

# Remove documentation files (optional - keep if you want reference)
# Uncomment these if you want to remove them:
# rm -f THUMBNAIL_FIX_INSTRUCTIONS.md
# rm -f DEPLOYMENT_TROUBLESHOOTING.md
# rm -f THUMBNAIL_ISSUE_DIAGNOSIS.md
# rm -f FINAL_FIX_STEPS.md
# rm -f README_THUMBNAIL_FIX.md
# rm -f BULK_UPLOAD_QUICK_REFERENCE.md

echo "✓ Debug files removed"
echo ""
echo "Remaining files (you can keep or delete):"
echo "- create_symlink.sh (keep for future reference)"
echo "- SYMLINK_SOLUTION.md (keep for documentation)"
echo "- fix_permissions.sh (keep for future use)"
echo "- quick_fix.sh (can delete)"
echo "- All *_INSTRUCTIONS.md files (can delete or keep for reference)"
echo ""
echo "Done!"
