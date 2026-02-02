# 🔧 Thumbnail Display Fix - Quick Start

## Problem
Thumbnails upload successfully (stored in `writable/uploads/programs/thumbs/`) but don't display on the page.

## Root Cause
Since permissions are already 777, the issue is **NOT permissions**. It's most likely:
1. **Base URL misconfiguration** (99% of cases)
2. Route not working properly
3. Browser caching old URLs

---

## 🚀 Quick Fix (Choose One)

### Option 1: Automated Script (Recommended)

```bash
# Make script executable
chmod +x quick_fix.sh

# Run the script
./quick_fix.sh

# Follow the prompts
```

### Option 2: Manual Fix (3 Steps)

#### Step 1: Fix Base URL

Create or edit `.env` file in your project root:

```env
app.baseURL = 'https://yourdomain.com/'
app.indexPage = ''
CI_ENVIRONMENT = production
```

**Replace `yourdomain.com` with your actual domain!**

#### Step 2: Clear Cache

```bash
php spark cache:clear
```

#### Step 3: Restart Web Server

```bash
# For Apache
sudo systemctl restart apache2

# For Nginx
sudo systemctl restart nginx
```

---

## 🔍 Verify the Fix

1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Visit your Programs page**
3. **Check if thumbnails display**

If still not working, proceed to debugging.

---

## 🐛 Debugging (If Still Not Working)

### Quick Debug

1. Upload `debug_thumbnails.php` to your `public` directory
2. Access: `https://yourdomain.com/debug_thumbnails.php`
3. Review all checks
4. **DELETE the file after debugging**

### Check Browser Console

1. Open Programs page
2. Press **F12** (Developer Tools)
3. Go to **Console** tab - look for errors
4. Go to **Network** tab
5. Reload page
6. Find thumbnail requests
7. Check status: 200 (OK), 404 (Not Found), 403 (Forbidden)?

### Test Direct Access

Try accessing a thumbnail directly:
```
https://yourdomain.com/writable/uploads/programs/thumbs/[filename]
```

**Expected:** Image should display
**If 404:** Route not configured
**If 403:** Permission issue (unlikely with 777)
**If 500:** PHP error in FileController

---

## 📋 Common Issues & Solutions

### Issue 1: Base URL Still Wrong

**Symptom:** Images try to load from `http://localhost:8080/`

**Solution:**
```bash
# Check current base URL
grep baseURL .env

# Should show: app.baseURL = 'https://yourdomain.com/'
# NOT: http://localhost:8080/

# If wrong, edit .env and fix it
nano .env
```

### Issue 2: Route Not Working

**Symptom:** 404 errors when accessing thumbnails

**Solution:**
```bash
# Check if route exists
php spark routes | grep writable

# Should show: GET writable/uploads/(.+) → FileController::serve/$1

# If missing or shows (:any), edit app/Config/Routes.php
# Change to: $routes->get('writable/uploads/(.+)', 'FileController::serve/$1');
```

### Issue 3: Browser Cache

**Symptom:** Still shows old URLs

**Solution:**
- Clear browser cache (Ctrl+Shift+Delete)
- Try incognito/private mode
- Hard refresh (Ctrl+Shift+R)

### Issue 4: .htaccess Missing

**Symptom:** No routes work at all

**Solution:**
```bash
# Check if .htaccess exists
ls -la public/.htaccess

# If missing, create it with mod_rewrite rules
# See DEPLOYMENT_TROUBLESHOOTING.md for content
```

---

## 📁 Files Included

| File | Purpose | Action |
|------|---------|--------|
| `quick_fix.sh` | Automated fix script | Run on server |
| `debug_thumbnails.php` | Diagnostic tool | Upload to public/, then DELETE |
| `fix_permissions.sh` | Permission fix (not needed if 777) | Optional |
| `THUMBNAIL_ISSUE_DIAGNOSIS.md` | Detailed diagnosis guide | Read if issues persist |
| `DEPLOYMENT_TROUBLESHOOTING.md` | Complete troubleshooting | Reference guide |
| `THUMBNAIL_FIX_INSTRUCTIONS.md` | Step-by-step instructions | Follow if manual fix needed |

---

## ✅ Success Checklist

After applying fixes, verify:

- [ ] `.env` file has correct base URL
- [ ] Base URL uses your actual domain (not localhost)
- [ ] Route exists: `writable/uploads/(.+)`
- [ ] Cache cleared
- [ ] Web server restarted
- [ ] Browser cache cleared
- [ ] Thumbnails display on Programs page
- [ ] No errors in browser console
- [ ] Direct thumbnail access works

---

## 🆘 Still Not Working?

### Get Detailed Diagnostics

1. Run `debug_thumbnails.php`
2. Check browser console (F12)
3. Check server logs:
   ```bash
   tail -f writable/logs/log-*.log
   tail -f /var/log/apache2/error.log  # or nginx
   ```

### Provide This Info for Help

- Output from `debug_thumbnails.php`
- Screenshot of browser console errors
- Screenshot of Network tab (F12)
- Your domain name
- Output of: `php spark routes | grep writable`
- Output of: `grep baseURL .env`

---

## 💡 Why This Happens

**Local Development:**
- Base URL: `http://localhost:8080/`
- Works fine because that's correct for local

**Production Deployment:**
- Base URL still: `http://localhost:8080/` ❌
- Should be: `https://yourdomain.com/` ✅
- Images try to load from localhost (which doesn't exist on production)

**The Fix:**
Update base URL to match your production domain!

---

## 🔒 Security Note

After fixing, ensure:
- `writable` directory is NOT publicly accessible
- Files are served through FileController (not direct access)
- Delete `debug_thumbnails.php` after use
- Set proper permissions (755 for dirs, 644 for files)
- Don't use 777 in production (use 755/644 instead)

---

## 📞 Quick Support

**Most Common Fix:**
```bash
# Edit .env
nano .env

# Add/update this line:
app.baseURL = 'https://yourdomain.com/'

# Save, then:
php spark cache:clear
sudo systemctl restart apache2
```

**That's it!** 99% of the time, this fixes the issue.
