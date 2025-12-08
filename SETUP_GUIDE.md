# Open Boost UI - Complete Setup Guide

## Problem That Was Fixed

### What Was Happening Before
When users installed the package and answered "Y" to download resources:
1. ✅ The Composer plugin was being triggered
2. ✅ npm-asset libraries were downloading to `vendor/npm-asset/` in the consuming project
3. ❌ BUT the plugin was only creating **empty placeholder files** in `resources/assets/`
4. ❌ The service provider was publishing empty files to `public/vendor/open-boost/`
5. ❌ Result: Select2, Choices, etc. had no actual JS/CSS files to load

### Root Cause
The plugin's `downloadAndConfigureResources()` method was NOT:
- Copying actual library files from `vendor/npm-asset/` 
- It only created placeholder stubs with comments

---

## What Was Fixed

### 1. Plugin Now Copies Real Files (`src/Composer/Plugin.php`)
- **Before**: Created empty placeholders
- **After**: Copies actual JS/CSS from `vendor/npm-asset/` to `resources/assets/`
- Maps each library to its npm-asset source path and extracts needed files
- Example:
  - Source: `vendor/npm-asset/select2/dist/js/select2.min.js`
  - Destination: `resources/assets/select2/select2.min.js`

### 2. Added npm-asset Dependencies (`composer.json`)
- **Before**: No npm-asset dependencies listed
- **After**: Added npm-asset packages to `require-dev`:
  ```json
  "require-dev": {
    "npm-asset/jquery": "^3.6",
    "npm-asset/select2": "^4.0",
    "npm-asset/choices.js": "^11.0",
    ...
  }
  ```

### 3. Added npm-asset Repository (`composer.json`)
- Added Asset Packagist repository so npm packages can be installed via Composer
- URL: `https://asset-packagist.org`

### 4. Improved Smart Path Detection (`src/Composer/Plugin.php`)
- Plugin now automatically finds vendor path whether running in:
  - Package's own vendor directory (monorepo setup)
  - Consuming project's vendor directory (typical case)
  - Custom vendor dir via Composer config

### 5. Added Better Logging
- Shows which files are being copied
- Logs format: `✓ Copied select2/select2.min.js`
- Helps users understand what's happening

---

## New Complete Flow

### Step 1: User Runs Install
```bash
composer require open-boost/open-boost-ui
```

### Step 2: Interactive Prompt
```
OpenBoost: do you want to download resources? [Y/N] y
```

### Step 3: Plugin Auto-Configuration (Happens Automatically)
1. Detects user answered Y
2. Finds vendor directory (auto-detects consuming project)
3. Copies real JS/CSS from:
   - `vendor/npm-asset/jquery/dist/` → `resources/assets/jquery/`
   - `vendor/npm-asset/select2/dist/` → `resources/assets/select2/`
   - `vendor/npm-asset/flatpickr/dist/` → `resources/assets/flatpickr/`
   - (etc. for all 10 libraries)
4. Logs progress: `✓ Copied select2/select2.min.js`, etc.

### Step 4: User Publishes Assets
```bash
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
```

This copies configured assets to:
- `public/vendor/open-boost/assets/jquery/jquery.min.js`
- `public/vendor/open-boost/assets/select2/select2.min.js`
- `public/vendor/open-boost/assets/select2/select2.min.css`
- (etc.)

### Step 5: User Includes in Layout
In `resources/views/layouts/app.blade.php`:

```blade
<!-- Head -->
<link href="{{ asset('vendor/open-boost/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.css') }}" rel="stylesheet">
...

<!-- Body -->
<script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.min.js') }}"></script>
...
<script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
```

### Step 6: Use Components
```blade
<x-openBoost-select name="tags" lib="select2" theme="bootstrap">
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

✅ **Select2 now works!** Files exist, are loaded, and initialized.

---

## Library Mappings

The plugin knows where to find each library in npm-asset:

| Library | npm-asset Source Path | Files Copied |
|---------|----------------------|-------------|
| jQuery | `npm-asset/jquery/dist/` | `jquery.min.js`, `jquery.js` |
| Select2 | `npm-asset/select2/dist/` | `js/select2.min.js`, `css/select2.min.css` |
| Choices.js | `npm-asset/choices.js/public/assets/` | `scripts/choices.min.js`, `styles/choices.min.css` |
| Flatpickr | `npm-asset/flatpickr/dist/` | `flatpickr.min.js`, `flatpickr.css` |
| Chart.js | `npm-asset/chart.js/dist/` | `chart.min.js` |
| ApexCharts | `npm-asset/apexcharts/dist/` | `apexcharts.min.js`, `apexcharts.css` |
| Quill | `npm-asset/quill/dist/` | `quill.min.js`, `quill.snow.css` |
| SimpleMDE | `npm-asset/simplemde/dist/` | `simplemde.min.js`, `simplemde.min.css` |
| Trix | `npm-asset/trix/dist/` | `trix.js`, `trix.css` |
| DataTables | `npm-asset/datatables.net/js/` | `jquery.dataTables.min.js` |

---

## Troubleshooting

### Debug Helper
Open browser console and run:
```javascript
OpenBoost.debug()
```

Shows:
- ✅/❌ jQuery loaded
- ✅/❌ Select2 loaded
- ✅/❌ All other libraries
- Count of components found
- Initialization status

### If Select2 Still Doesn't Work
1. Check browser console for JS errors
2. Verify files exist: `public/vendor/open-boost/assets/select2/select2.min.js`
3. Ensure jQuery is loaded BEFORE Select2
4. Run `OpenBoost.debug()` to diagnose

---

## Files Changed

1. **`src/Composer/Plugin.php`** - Complete rewrite of `downloadAndConfigureResources()`
2. **`composer.json`** - Added npm-asset dependencies and repository
3. **`README.md`** - Updated with correct setup flow
4. **`resources/js/open-boost-init.js`** - Enhanced Select2 error messages
5. **`resources/views/components/openBoost/select.blade.php`** - Fixed data attributes

---

## Testing the Fix

### For Package Developers
```bash
cd /path/to/consuming-project
composer require open-boost/open-boost-ui:dev-master --prefer-source

# During install, answer Y to download resources
# Check resources/assets/ has real files:
ls vendor/open-boost/open-boost-ui/resources/assets/select2/
# Should show: select2.min.js, select2.js, select2.min.css, select2.css (NOT empty)

# Publish assets
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui

# Check public folder
ls public/vendor/open-boost/assets/select2/
# Should show same files as above
```

### For End Users
After following the 3-step setup (install, publish, include in layout):
1. Create a test page with `<x-openBoost-select>`
2. Open page in browser
3. Click the select - should see Select2 dropdown styling
4. Type to search - should filter options
5. Run `OpenBoost.debug()` - should show everything loaded ✅

---

## Why This Approach?

This design provides:
1. **Self-contained package** - No external CDN dependencies
2. **Single source of truth** - All libraries bundled in the package
3. **Offline support** - Works without internet after install
4. **Version control** - All versions locked in composer.json
5. **Developer friendly** - Simple setup: install → publish → include
6. **Easy customization** - Users can modify files in `public/vendor/open-boost/`

