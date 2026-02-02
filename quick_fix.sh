#!/bin/bash
# Quick Fix Script for Thumbnail Display Issue
# Run this on your deployment server

echo "=========================================="
echo "Thumbnail Display - Quick Fix Script"
echo "=========================================="
echo ""

# Get the domain
echo "What is your domain? (e.g., example.com or subdomain.example.com)"
read -p "Domain: " DOMAIN

if [ -z "$DOMAIN" ]; then
    echo "Error: Domain cannot be empty"
    exit 1
fi

# Determine protocol
read -p "Use HTTPS? (y/n, default: y): " USE_HTTPS
USE_HTTPS=${USE_HTTPS:-y}

if [ "$USE_HTTPS" = "y" ] || [ "$USE_HTTPS" = "Y" ]; then
    PROTOCOL="https"
else
    PROTOCOL="http"
fi

BASE_URL="${PROTOCOL}://${DOMAIN}/"

echo ""
echo "Base URL will be set to: $BASE_URL"
read -p "Is this correct? (y/n): " CONFIRM

if [ "$CONFIRM" != "y" ] && [ "$CONFIRM" != "Y" ]; then
    echo "Aborted."
    exit 1
fi

echo ""
echo "Applying fixes..."
echo ""

# 1. Create or update .env file
echo "1. Updating .env file..."
if [ -f .env ]; then
    # Update existing .env
    if grep -q "app.baseURL" .env; then
        sed -i "s|app.baseURL.*|app.baseURL = '$BASE_URL'|" .env
        echo "   ✓ Updated app.baseURL in .env"
    else
        echo "app.baseURL = '$BASE_URL'" >> .env
        echo "   ✓ Added app.baseURL to .env"
    fi
    
    if grep -q "app.indexPage" .env; then
        sed -i "s|app.indexPage.*|app.indexPage = ''|" .env
        echo "   ✓ Updated app.indexPage in .env"
    else
        echo "app.indexPage = ''" >> .env
        echo "   ✓ Added app.indexPage to .env"
    fi
else
    # Create new .env
    cat > .env << EOF
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = '$BASE_URL'
app.indexPage = ''

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

# Add your database settings here

EOF
    echo "   ✓ Created .env file"
fi

# 2. Check and fix route
echo ""
echo "2. Checking route configuration..."
if grep -q "writable/uploads/(.+)" app/Config/Routes.php; then
    echo "   ✓ Route already configured correctly"
else
    if grep -q "writable/uploads/(:any)" app/Config/Routes.php; then
        # Fix the route
        sed -i "s|writable/uploads/(:any)|writable/uploads/(.+)|" app/Config/Routes.php
        echo "   ✓ Fixed route from (:any) to (.+)"
    else
        echo "   ⚠ Route not found - you may need to add it manually"
        echo "   Add this line to app/Config/Routes.php:"
        echo "   \$routes->get('writable/uploads/(.+)', 'FileController::serve/\$1');"
    fi
fi

# 3. Set permissions
echo ""
echo "3. Setting file permissions..."
if [ -d writable/uploads ]; then
    chmod -R 755 writable/uploads
    echo "   ✓ Set permissions to 755"
else
    echo "   ⚠ writable/uploads directory not found"
fi

# 4. Clear cache
echo ""
echo "4. Clearing cache..."
if [ -f spark ]; then
    php spark cache:clear 2>/dev/null
    echo "   ✓ Cache cleared"
else
    echo "   ⚠ spark file not found"
fi

# 5. Restart web server
echo ""
echo "5. Restarting web server..."
read -p "   Restart web server? (y/n): " RESTART

if [ "$RESTART" = "y" ] || [ "$RESTART" = "Y" ]; then
    # Detect web server
    if systemctl is-active --quiet apache2; then
        sudo systemctl restart apache2
        echo "   ✓ Apache restarted"
    elif systemctl is-active --quiet httpd; then
        sudo systemctl restart httpd
        echo "   ✓ Apache (httpd) restarted"
    elif systemctl is-active --quiet nginx; then
        sudo systemctl restart nginx
        echo "   ✓ Nginx restarted"
    else
        echo "   ⚠ Could not detect web server - restart manually"
    fi
fi

echo ""
echo "=========================================="
echo "Fix Applied!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Clear your browser cache (Ctrl+Shift+Delete)"
echo "2. Visit your site: $BASE_URL"
echo "3. Check if thumbnails now display"
echo ""
echo "If still not working:"
echo "1. Upload debug_thumbnails.php to public directory"
echo "2. Access: ${BASE_URL}debug_thumbnails.php"
echo "3. Review the diagnostic report"
echo ""
echo "For detailed troubleshooting, see:"
echo "- THUMBNAIL_ISSUE_DIAGNOSIS.md"
echo "- DEPLOYMENT_TROUBLESHOOTING.md"
echo ""
