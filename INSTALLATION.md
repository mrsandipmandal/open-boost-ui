# OpenBoost UI - Installation & Setup Guide

Complete step-by-step guide to install and configure OpenBoost UI in your Laravel project.

---

## 📋 Prerequisites

- **Laravel** 9.0 or higher
- **PHP** 8.0 or higher
- **Composer** 2.0 or higher
- Modern web browser with JavaScript enabled

---

## ⚡ Quick Install (3 Steps)

### Step 1: Install via Composer
```bash
composer require open-boost/open-boost-ui
```

### Step 2: Publish Assets
```bash
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
```

### Step 3: Add to Layout

In your main layout file (`resources/views/layouts/app.blade.php`):

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Bootstrap or Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- OpenBoost Assets (CSS) -->
    @openBoostAssets
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <!-- OpenBoost Scripts (JS) -->
    @openBoostScripts
</body>
</html>
```

✅ **Done!** You're ready to use components.

---

## 🔍 Verify Installation

### Method 1: Check Files
Verify these directories exist:
- ✅ `resources/views/vendor/boost/components/openBoost/`
- ✅ `public/vendor/open-boost/assets/`
- ✅ `public/vendor/open-boost/js/`

### Method 2: Browser Console
```javascript
// Open browser DevTools (F12) and run:
OpenBoost.debug()

// You should see:
// 🔍 OpenBoost Debug Info
// jQuery ($): ✅ Loaded
// Select2: ✅ Loaded
// Flatpickr: ✅ Loaded
// ... etc
```

### Method 3: Test Component
```blade
<x-openBoost-select name="test">
    <option value="1">Option 1</option>
</x-openBoost-select>
```

If it renders without errors, installation is successful! 🎉

---

## 📦 Fresh Project Setup

### Create New Laravel Project
```bash
laravel new myproject
cd myproject
```

### Install OpenBoost
```bash
composer require open-boost/open-boost-ui
```

### Setup Layout
Create `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @openBoostAssets
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">MyApp</a>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    @openBoostScripts
</body>
</html>
```

### Create Welcome Page
Create `resources/views/welcome.blade.php`:

```blade
@extends('layouts.app')

@section('content')
<h1>Welcome to OpenBoost</h1>

<x-openBoost-select name="category" lib="select2">
    <option value="">Select category...</option>
    <option value="web">Web Development</option>
    <option value="mobile">Mobile Development</option>
</x-openBoost-select>

<x-openBoost-notification type="success" class="mt-3">
    OpenBoost is installed and ready to use!
</x-openBoost-notification>
@endsection
```

### Create Route
In `routes/web.php`:

```php
Route::get('/', function () {
    return view('welcome');
});
```

### Run Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` 🎉

---

## 🛠️ Troubleshooting Installation

### Problem 1: "Unable to locate component"

**Error Message:**
```
InvalidArgumentException: Unable to locate a class or view for component [openBoost-select]
```

**Cause:** Service provider not registered or views not published

**Solution:**
```bash
# Clear caches
php artisan cache:clear
php artisan view:clear

# Republish views
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force

# Restart server
php artisan serve
```

---

### Problem 2: "jQuery is not loaded" (Select2)

**Error in Browser Console:**
```
Select2: jQuery is not loaded. Include jQuery before open-boost-init.js
```

**Cause:** jQuery script missing or in wrong position

**Solution:**
Ensure your layout has `@openBoostScripts` before `</body>` (it loads jQuery automatically)

```blade
<body>
    <!-- Your content -->
    
    <!-- This must be here, at the end -->
    @openBoostScripts
</body>
```

---

### Problem 3: "Select2 library is not loaded"

**Error in Browser Console:**
```
Select2: Select2 library is not loaded
```

**Cause:** Assets not published or page cached

**Solution:**
```bash
# 1. Republish assets
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force

# 2. Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# 3. Check files exist
dir public\vendor\open-boost\assets\select2\  # Windows
ls public/vendor/open-boost/assets/select2/    # Mac/Linux

# 4. Restart server
php artisan serve
```

---

### Problem 4: Components show but no styling

**Cause:** Bootstrap/Tailwind CSS or OpenBoost CSS not loaded

**Solution:**
Verify CSS is included in `<head>`:

```blade
<head>
    <!-- Your main CSS framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- OpenBoost CSS (loads all component styles) -->
    @openBoostAssets
</head>
```

---

### Problem 5: Components initialize but behave strangely

**Cause:** Multiple versions of libraries or conflicting JavaScript

**Solution:**
1. Remove any duplicate library includes
2. Check for JavaScript errors in console (F12)
3. Make sure `@openBoostScripts` is the last script before `</body>`

---

## 🎯 Next Steps After Installation

### 1. Explore Components
Visit the [Components Documentation](../COMPONENTS.md) to see all available components.

### 2. Create Your First Form
```blade
@extends('layouts.app')

@section('content')
<div class="card p-4">
    <h2>Create User</h2>
    
    <form method="POST" action="/users">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <x-openBoost-select name="role">
                <option value="">Select role...</option>
                <option value="admin">Administrator</option>
                <option value="user">User</option>
            </x-openBoost-select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Notifications</label>
            <x-openBoost-toggle id="notifications" label="Enable" :checked="true" />
        </div>
        
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
```

### 3. Customize Styling
Use data attributes to add custom classes:

```blade
<x-openBoost-select name="category" class="border-2 border-blue-500">
    <option>...</option>
</x-openBoost-select>
```

### 4. Learn JavaScript API
```javascript
// Manually re-initialize components
OpenBoost.initAll();

// Get component data
const select = document.querySelector('[name="role"]');
const value = select.value;

// Listen to changes
select.addEventListener('change', function() {
    console.log('Selected:', this.value);
});
```

---

## 🔄 Upgrading

### From Previous Versions

```bash
# Update package
composer update open-boost/open-boost-ui

# Republish assets (replaces old files)
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force

# Clear caches
php artisan cache:clear
php artisan view:clear
```

---

## 🚀 Production Deployment

### Before Deployment

1. **Test Locally**
   ```bash
   php artisan serve
   ```

2. **Build Assets**
   ```bash
   npm run build  # If using Laravel Mix/Vite
   ```

3. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Deployment Commands

```bash
# On production server
composer install --no-dev
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
php artisan migrate
php artisan cache:clear
```

### Performance Optimization

Add to `config/app.php`:
```php
'debug' => false, // Disable debug mode
```

Add to `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

---

## 💡 Tips & Best Practices

### 1. Always Include Directives in Layout
```blade
<head>
    @openBoostAssets  <!-- CSS -->
</head>
<body>
    @openBoostScripts  <!-- JS, must be last -->
</body>
```

### 2. Use Proper Form Structure
```blade
<form method="POST" action="/submit">
    @csrf
    <div class="mb-3">
        <label>Field Name</label>
        <x-openBoost-select name="field">
            <option>...</option>
        </x-openBoost-select>
    </div>
</form>
```

### 3. Test in Multiple Browsers
- Chrome/Edge
- Firefox
- Safari
- Mobile browsers

### 4. Check Console Regularly
```javascript
// In browser console (F12)
OpenBoost.debug()
```

### 5. Keep Dependencies Updated
```bash
composer update
```

---

## 📞 Getting Help

- 📖 [Documentation](../README.md)
- 🐛 [Issue Tracker](https://github.com/mrsandipmandal/open-boost-ui/issues)
- 💬 [Discussions](https://github.com/mrsandipmandal/open-boost-ui/discussions)

---

**Successfully installed? Start building! 🚀**
