# Thumbnail Issue - Complete Diagnosis & Fix

## Current Situation
- ✅ Files upload successfully
- ✅ Files are stored in `writable/uploads/programs/thumbs/`
- ✅ Permissions are set to 777
- ❌ Thumbnails don't display on the page

## Most Likely Causes (in order)

### 1. Base URL Configuration (MOST COMMON)

Your `app/Config/App.php` has:
```php
public string $baseURL = 'http://localhost:8080/';
```

This is **WRONG** for production! It should be your actual domain.

**Fix:**

Create or edit `.env` file in your project root:

```env
# .env file
app.baseURL = 'https://yourdomain.com/'
# or if in subdirectory:
# app.baseURL = 'https://yourdomain.com/subfolder/'
```

**OR** edit `app/Config/App.php` directly:

```php
public string $baseURL = 'https://yourdomain.com/';
```

After changing, clear cache:
```bash
php spark cache:clear
```

### 2. Route Not Working

The route might not be loaded or configured correctly.

**Check:**
```bash
# View all routes
php spark routes

# Look for this line:
# GET  writable/uploads/(.+)  FileController::serve/$1
```

**If missing, add to `app/Config/Routes.php`:**
```php
$routes->get('writable/uploads/(.+)', 'FileController::serve/$1');
```

### 3. .htaccess Issues (Apache)

**Check if `public/.htaccess` exists and contains:**

```apache
# Disable directory browsing
Options -Indexes

# Rewrite engine
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    ErrorDocument 404 index.php
</IfModule>

# Disable server signature
ServerSignature Off
```

### 4. Index Page in URL

If your URLs look like: `https://yourdomain.com/index.php/program`

**Fix in `.env`:**
```env
app.indexPage = ''
```

**OR in `app/Config/App.php`:**
```php
public string $indexPage = '';
```

---

## Step-by-Step Debugging

### Step 1: Upload Debug Script

1. Upload `debug_thumbnails.php` to your `public` directory
2. Access: `https://yourdomain.com/debug_thumbnails.php`
3. Review all the checks
4. **DELETE the file after debugging**

### Step 2: Check Browser Console

1. Open your Programs page
2. Press F12 (Developer Tools)
3. Go to "Console" tab
4. Look for errors
5. Go to "Network" tab
6. Reload page
7. Find thumbnail requests
8. Check their status (200, 404, 403?)
9. Click on a failed request to see details

### Step 3: Check What URL is Being Generated

Add this temporarily to `app/Modules/Program/Views/index.php`:

```php
<?php if (!empty($program['thumbnail'])): ?>
    <?php 
    $thumbnailUrl = base_url('writable/uploads/programs/thumbs/' . $program['thumbnail']);
    echo "<!-- DEBUG: Thumbnail URL = $thumbnailUrl -->"; 
    ?>
    <img src="<?= $thumbnailUrl ?>" alt="Thumbnail" style="width: 50px;">
<?php endif ?>
```

Then view page source and look for the DEBUG comment. The URL should be:
```
https://yourdomain.com/writable/uploads/programs/thumbs/filename.png
```

NOT:
```
http://localhost:8080/writable/uploads/programs/thumbs/filename.png
```

### Step 4: Test Route Directly

Try accessing a thumbnail directly in your browser:
```
https://yourdomain.com/writable/uploads/programs/thumbs/[actual-filename]
```

**Expected Results:**
- ✅ **200 OK** - Image displays = Route works!
- ❌ **404 Not Found** - Route not configured
- ❌ **403 Forbidden** - Permission issue (but you have 777)
- ❌ **500 Error** - PHP error in FileController

### Step 5: Check Logs

```bash
# CodeIgniter logs
tail -f writable/logs/log-*.log

# Apache error log
tail -f /var/log/apache2/error.log

# Nginx error log
tail -f /var/log/nginx/error.log
```

---

## Quick Fixes to Try

### Fix 1: Update Base URL

```bash
# Edit .env file
nano .env

# Add or update:
app.baseURL = 'https://yourdomain.com/'

# Save and clear cache
php spark cache:clear
```

### Fix 2: Verify Route

```bash
# Check if route exists
php spark routes | grep writable

# If not found, add to app/Config/Routes.php:
# $routes->get('writable/uploads/(.+)', 'FileController::serve/$1');
```

### Fix 3: Clear All Caches

```bash
php spark cache:clear
php spark route:clear  # If available in your CI4 version

# Restart web server
sudo systemctl restart apache2  # or nginx
```

### Fix 4: Check FileController

Make sure `app/Controllers/FileController.php` exists and has the `serve` method.

---

## Testing Checklist

Run through these tests:

1. **File exists:**
   ```bash
   ls -la writable/uploads/programs/thumbs/
   ```

2. **Permissions correct:**
   ```bash
   ls -l writable/uploads/programs/thumbs/
   # Should show: -rwxrwxrwx (777)
   ```

3. **Base URL correct:**
   ```bash
   grep baseURL .env
   # Should show your actual domain
   ```

4. **Route exists:**
   ```bash
   php spark routes | grep writable
   # Should show: GET writable/uploads/(.+)
   ```

5. **Direct access works:**
   - Open: `https://yourdomain.com/writable/uploads/programs/thumbs/[filename]`
   - Should display the image

6. **Browser console clean:**
   - F12 → Console tab
   - Should have no errors

---

## Common Mistakes

1. ❌ Base URL still set to `localhost`
2. ❌ Route uses `(:any)` instead of `(.+)`
3. ❌ Missing `.htaccess` in public directory
4. ❌ `mod_rewrite` not enabled (Apache)
5. ❌ Wrong document root in web server config
6. ❌ Cache not cleared after changes

---

## If Still Not Working

### Temporary Workaround (NOT RECOMMENDED FOR PRODUCTION)

As a test, you can temporarily make the writable directory publicly accessible:

1. Create a symlink:
   ```bash
   ln -s ../writable/uploads public/uploads
   ```

2. Update views to use:
   ```php
   <img src="<?= base_url('uploads/programs/thumbs/' . $program['thumbnail']) ?>">
   ```

3. If this works, it confirms the issue is with the route, not permissions.

**⚠️ This is NOT secure for production! Use only for testing.**

---

## Final Solution

Based on your symptoms (uploads work, 777 permissions, but images don't show), the issue is **99% likely to be the base URL configuration**.

**Do this:**

1. Create/edit `.env` file:
   ```env
   app.baseURL = 'https://yourdomain.com/'
   app.indexPage = ''
   CI_ENVIRONMENT = production
   ```

2. Clear cache:
   ```bash
   php spark cache:clear
   ```

3. Restart web server:
   ```bash
   sudo systemctl restart apache2
   ```

4. Test again

This should fix it!

---

## Need More Help?

Run `debug_thumbnails.php` and send me:
1. The complete output
2. Screenshot of browser console (F12)
3. Screenshot of Network tab showing failed request
4. Your actual domain name
5. Output of: `php spark routes | grep writable`
