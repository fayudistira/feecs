#!/bin/bash
# Create symlink to make uploads accessible
# This is the cleanest solution for production

echo "Creating symlink for uploads..."

# Navigate to public directory
cd public

# Remove old symlink if exists
if [ -L "uploads" ]; then
    echo "Removing old symlink..."
    rm uploads
fi

# Create new symlink
ln -s ../writable/uploads uploads

echo "✓ Symlink created: public/uploads -> writable/uploads"
echo ""
echo "Files are now accessible at:"
echo "https://yourdomain.com/uploads/programs/thumbs/file.png"
echo ""
echo "You need to update the views to use the new path."
