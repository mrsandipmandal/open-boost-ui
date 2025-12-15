# 🚀 OpenBoost UI - Professional Blade Components Library

[![Latest Stable Version](https://img.shields.io/packagist/v/open-boost/open-boost-ui.svg?style=flat-square)](https://packagist.org/packages/open-boost/open-boost-ui)
[![License](https://img.shields.io/packagist/l/open-boost/open-boost-ui.svg?style=flat-square)](LICENSE.txt)
[![PHP Version](https://img.shields.io/packagist/php-v/open-boost/open-boost-ui.svg?style=flat-square)](https://packagist.org/packages/open-boost/open-boost-ui)

**A comprehensive, production-ready Blade component library for Laravel** with 15+ pre-built UI components inspired by Alpine.js and modern component frameworks.

### ✨ Key Features

- 🎨 **15+ Ready-to-Use Components** - Accordion, Carousel, Tabs, Modals, Selects, Datepickers, Charts, and more
- 📦 **Zero External Dependencies** - All assets bundled, no npm required
- 🎯 **Auto-Initialization** - Components initialize automatically with vanilla JavaScript
- ♿ **Fully Accessible** - ARIA attributes, keyboard navigation, semantic HTML
- 🎭 **Multiple Themes** - Bootstrap 5 and Tailwind CSS support
- 📱 **Responsive Design** - Mobile-first, works on all devices
- ⚡ **Performance Optimized** - Lazy-loaded, minimal JavaScript footprint
- 🔌 **Framework Agnostic** - Works with any Laravel version 9+

---

## ⚡ Quick Start (3 Steps)

### 1. Install Package
```bash
composer require open-boost/open-boost-ui
```

### 2. Publish Assets
```bash
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
```

### 3. Add to Your Layout (`resources/views/layouts/app.blade.php`)

**In `<head>`:**
```blade
@openBoostAssets
```

**Before `</body>`:**
```blade
@openBoostScripts
```

### ✅ Done! Use Any Component:

```blade
<x-openBoost-select name="tags" lib="select2">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

**That's it!** No manual script includes needed! 🎉

---

## Configuration

Located at:

Each library directory contains the necessary JS and CSS files for that component.

---

## Manual Resource Configuration

If you skipped resource download during install, configure them later:

```powershell
php artisan openboost:install-resources
```

Answer the prompt to download and configure assets into `resources/assets/`.

---

## Local development / testing (use local package copy)

If you're developing the package locally and want your consuming project to use the workspace copy:

```powershell
# from the consuming project folder
composer config repositories.open-boost path ../open-boost-ui
composer require open-boost/open-boost-ui:dev-master --prefer-source
```

---

## Setup: Include Assets and Initialize Components

After installing the package, you must include the frontend assets and initialize the components in your Blade layout.

### Step 1: Add CSS in `<head>`

In your main Blade layout (e.g., `resources/views/layouts/app.blade.php`), add these in the `<head>`:

```blade
<!-- Select2 CSS -->
<link href="{{ asset('vendor/open-boost/assets/select2/select2.min.css') }}" rel="stylesheet">

<!-- Flatpickr CSS -->
<link href="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.css') }}" rel="stylesheet">

<!-- Quill CSS -->
<link href="{{ asset('vendor/open-boost/assets/quill/quill.snow.css') }}" rel="stylesheet">

<!-- SimpleMDE CSS -->
<link href="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.css') }}" rel="stylesheet">

<!-- Trix CSS -->
<link href="{{ asset('vendor/open-boost/assets/trix/trix.css') }}" rel="stylesheet">

<!-- ApexCharts CSS -->
<link href="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.css') }}" rel="stylesheet">

<!-- DataTables CSS -->
<link href="{{ asset('vendor/open-boost/assets/datatables.net/datatables.min.css') }}" rel="stylesheet">

<!-- Choices.js CSS -->
<link href="{{ asset('vendor/open-boost/assets/choices.js/choices.min.css') }}" rel="stylesheet">
```

### Step 2: Add JavaScript before `</body>`

At the end of your Blade layout (before `</body>`), add:

```blade
<!-- jQuery -->
<script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>

<!-- Flatpickr JS -->
<script src="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.min.js') }}"></script>

<!-- Quill JS -->
<script src="{{ asset('vendor/open-boost/assets/quill/quill.min.js') }}"></script>

<!-- SimpleMDE JS -->
<script src="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.js') }}"></script>

<!-- ApexCharts JS -->
<script src="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.min.js') }}"></script>

<!-- Chart.js JS -->
<script src="{{ asset('vendor/open-boost/assets/chart.js/chart.min.js') }}"></script>

<!-- DataTables JS -->
<script src="{{ asset('vendor/open-boost/assets/datatables.net/datatables.min.js') }}"></script>

<!-- Choices.js JS -->
<script src="{{ asset('vendor/open-boost/assets/choices.js/choices.min.js') }}"></script>

<!-- Trix JS -->
<script src="{{ asset('vendor/open-boost/assets/trix/trix.js') }}"></script>

<!-- OpenBoost Initialization -->
<script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
```

**That's it!** The `open-boost-init.js` script will automatically initialize all components when the DOM is ready.
```

### Step 3: Publish Assets (Optional)

If you want to copy the bundled assets to your project's `public/vendor/` for serving directly:

```powershell
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui
```

This publishes assets to:
- Views → `resources/views/vendor/boost/`
- Config → `config/open-boost.php`
- Assets → `public/vendor/open-boost/`

---

## Troubleshooting

### Select2/Choices Not Working

**Problem:** Component renders but dropdown doesn't activate.

**Solution:** Ensure all 3 setup steps are completed:

1. ✅ **Answered Y during install** to download and configure resources
   - When you ran `composer require open-boost/open-boost-ui`
   - The plugin prompted: `OpenBoost: do you want to download resources? [Y/N]`
   - If you said N, run: `php artisan openboost:install-resources`

2. ✅ **Published assets to public folder:**
   ```bash
   php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
   ```
   - Check that files exist: `public/vendor/open-boost/assets/select2/select2.min.js` ✅

3. ✅ **Included jQuery BEFORE Select2 in your layout:**
   ```blade
   <!-- CORRECT ORDER -->
   <script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>
   <script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
   ```

4. ✅ **Check browser console for errors:**
   - Open DevTools (F12)
   - Look for red error messages
   - The init script logs: `🚀 OpenBoost: Initializing components...`
   - And: `Select2 initialized on: element-id`

**Common Issues:**

| Error | Cause | Fix |
|-------|-------|-----|
| `jQuery is not loaded` | jQuery script missing or in wrong order | Include jQuery before Select2 |
| `Select2 library is not loaded` | Select2 JS missing or jQuery missing | Check Step 3 above - include jQuery first |
| `Cannot read property 'fn'` | jQuery not loaded before Select2 | Move jQuery script earlier in `</body>` |
| Select renders but no styling | CSS file not included | Add Select2 CSS to `<head>` |
| Components don't initialize | `open-boost-init.js` not included | Add init script before `</body>` |

**Use the debug helper:**
```javascript
// Open browser console (F12) and run:
OpenBoost.debug()
```

This shows:
- ✅/❌ Which libraries are loaded
- How many components were found on the page
- Whether initialization is working

---

### Resources Not Downloaded

**Problem:** During `composer require`, you answered N to the resources prompt.

**Solution:** Configure resources manually:
```powershell
php artisan openboost:install-resources
```

Then answer Y when prompted.

---

### Assets Directory Empty After Install

**Problem:** `vendor/open-boost/open-boost-ui/resources/assets/` folder is empty.

**Solution:** Run the install command:
```powershell
php artisan openboost:install-resources
```

The plugin will download and copy actual library files from npm-asset packages.

---

### Components Not Rendering

**Problem:** `<x-openBoost-select>` tag produces error.

**Solution:** Ensure service provider is registered. Check `config/app.php` has auto-discovery enabled or manually register:

```php
// config/app.php
'providers' => [
    // ...
    OpenBoost\UI\OpenBoostServiceProvider::class,
],
```

---

## Component Examples

### Dropdown

```blade
<x-openBoost-dropdown label="Menu">
    <a href="#">Profile</a>
    <a href="#">Logout</a>
</x-openBoost-dropdown>
```

### Modal

```blade
<x-openBoost-modal id="exampleModal" title="Demo Modal">
    Modal content goes here.
</x-openBoost-modal>

<button data-openBoost-modal-open="exampleModal">Open Modal</button>
```

### Select

```blade
<x-openBoost-select name="tags[]" multiple lib="choices">
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

### Datepicker

```blade
<x-openBoost-datepicker name="event_date" mode="single" />
```

### Chart

```blade
<x-openBoost-chart
    type="bar"
    :data="[
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [[ 'label' => 'Data', 'data' => [10,20,30] ]]
    ]"
/>
```

### Text Editor

```blade
<x-openBoost-editor name="content" engine="quill">
    {!! old('content') !!}
</x-openBoost-editor>
```

---

## Configuration

Located at `config/open-boost.php` after publishing vendor resources.

Example:

```php
return [
    'default_chart' => 'chartjs',
    'editor' => 'quill',
];
```

---

## Contributing

Contributions are welcome. Please open an issue or submit a PR with desired changes.

## License

MIT License © Sandip Mandal