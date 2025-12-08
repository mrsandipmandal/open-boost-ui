# 🎉 Auto-Loading Assets Feature - COMPLETE!

## What You Asked For

> "i want when component load then why not load lib="select2" ? i want to only call component and not include script tags"

## What I Built

A system that **automatically loads required JavaScript and CSS** when you use a component. No manual script tags needed!

---

## How It Works (3 Simple Steps)

### Step 1: Install & Publish (Same as before)
```bash
composer require open-boost/open-boost-ui
# Answer Y to download resources

php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
```

### Step 2: Add 2 Directives to Your Layout
In `resources/views/layouts/app.blade.php`:

**In `<head>`:**
```blade
@openBoostAssets
```

**Before `</body>`:**
```blade
@openBoostScripts
```

### Step 3: Use Components - Assets Load Automatically!
```blade
<x-openBoost-select name="tags" lib="select2" theme="bootstrap">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

✅ **Select2 loads automatically!** No `<script>` tags needed!

---

## Complete Example Layout

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    
    <!-- Your CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- OpenBoost: Auto-loads component CSS -->
    @openBoostAssets
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>

    <!-- Your JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- OpenBoost: Auto-loads component JS + jQuery + Init -->
    @openBoostScripts
</body>
</html>
```

---

## How It Works Behind The Scenes

1. **Component registers its library:**
   ```php
   // Inside select component:
   @php
       \OpenBoost\UI\Services\AssetManager::require('select2');
   @endphp
   ```

2. **Directives collect what's needed:**
   ```blade
   @openBoostAssets  <!-- Outputs CSS for: select2, flatpickr, quill, etc -->
   @openBoostScripts <!-- Outputs JS for: jquery, select2, flatpickr, etc -->
   ```

3. **Only needed assets load:**
   ```html
   <!-- If you only use select2 component -->
   <link href="select2.min.css" rel="stylesheet">
   <script src="jquery.min.js"></script>
   <script src="select2.min.js"></script>
   <script src="open-boost-init.js"></script>
   
   <!-- Flatpickr, Quill, etc. NOT included because not used -->
   ```

---

## Multiple Components

Use as many components as you want - assets load automatically:

```blade
<!-- Layout has: @openBoostAssets and @openBoostScripts -->

<!-- Your page uses multiple components -->
<x-openBoost-select name="tags" lib="select2">
    <option value="php">PHP</option>
</x-openBoost-select>

<x-openBoost-datepicker name="date" />

<x-openBoost-chart type="bar" :data="$chartData" />

<x-openBoost-editor name="content" engine="quill" />
```

**Result:**
- ✅ jQuery loads (needed by all)
- ✅ Select2 JS + CSS loads
- ✅ Flatpickr JS + CSS loads
- ✅ Chart.js loads
- ✅ Quill JS + CSS loads
- ✅ Init script loads (initializes everything)
- ❌ Choices, SimpleMDE, Trix NOT loaded (not used)

Perfect optimization! 🎯

---

## Supported Libraries (Auto-Load)

| Component | Library | What Loads |
|-----------|---------|-----------|
| Select | `select2` | select2.js + select2.css + jQuery |
| Select | `choices` | choices.js + choices.css + jQuery |
| Datepicker | `flatpickr` | flatpickr.js + flatpickr.css + jQuery |
| Chart | `chartjs` | chart.js + jQuery |
| Chart | `apexcharts` | apexcharts.js + apexcharts.css + jQuery |
| Editor | `quill` | quill.js + quill.css + jQuery |
| Editor | `simplemde` | simplemde.js + simplemde.css + jQuery |
| Editor | `trix` | trix.js + trix.css + jQuery |

Plus the init script always loads when any component is used.

---

## No More Manual Tags!

### Before (Your Old Problem):
```blade
<!-- Had to manually include EVERYTHING -->
<link href="{{ asset('vendor/open-boost/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.css') }}" rel="stylesheet">
<!-- ... 8 more links ... -->

<script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>
<!-- ... 10 more scripts ... -->

<!-- THEN use component -->
<x-openBoost-select ...></x-openBoost-select>
```

### After (Now):
```blade
<!-- Just two directives in layout -->
@openBoostAssets
<!-- ... page content ... -->
@openBoostScripts

<!-- Then use components -->
<x-openBoost-select ...></x-openBoost-select>
<!-- Assets load automatically! -->
```

✅ **Clean, simple, automatic!**

---

## Files Created/Modified

| File | Changes |
|------|---------|
| `src/Services/AssetManager.php` | NEW - Tracks required libraries and outputs asset tags |
| `src/OpenBoostServiceProvider.php` | Added `@openBoostAssets` and `@openBoostScripts` directives |
| `resources/views/components/openBoost/select.blade.php` | Auto-register "select2" or "choices" |
| `resources/views/components/openBoost/datepicker.blade.php` | Auto-register "flatpickr" |
| `resources/views/components/openBoost/chart.blade.php` | Auto-register "chartjs" or "apexcharts" |
| `resources/views/components/openBoost/editor.blade.php` | Auto-register editor engine |
| `README.md` | Updated setup to show new directives |
| `AUTO_ASSETS.md` | NEW - Complete documentation |

---

## Summary

**You asked:** "Why not load lib='select2' automatically?"

**I delivered:** An automatic asset management system where:
- ✅ Components register what they need
- ✅ Directives inject only used assets
- ✅ jQuery loads first (always needed)
- ✅ Libraries load in correct order
- ✅ Init script loads last (initializes everything)
- ✅ Zero manual script tags needed!

**All you do:** Add 2 directives to layout, use components, assets load automatically! 🚀

---

## Test It Now!

In your consuming project:

1. Update layout with `@openBoostAssets` and `@openBoostScripts`
2. Use a component:
   ```blade
   <x-openBoost-select name="test" lib="select2">
       <option value="">Select...</option>
       <option value="1">Option 1</option>
   </x-openBoost-select>
   ```
3. Open page - Select2 loads automatically!
4. Press F12, run `OpenBoost.debug()` - all libraries show ✅

Done! 🎉

