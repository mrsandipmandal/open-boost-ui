# Open Boost UI (open-boost/open-boost-ui)

Laravel Blade components and integrated frontend libraries (Select2, Choices, Flatpickr, Chart.js, ApexCharts, Quill, SimpleMDE, Trix, DataTables) with bundled assets — **no external npm/Composer dependencies needed**.

---

## ⚡ Quick Start (3 Steps)

### 1. Install Package
```powershell
composer require open-boost/open-boost-ui
```
When prompted: **Answer `Y`** to download resources (assets will be available in vendor)

### 2. Publish Assets to Public
```powershell
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui
```
This copies CSS, JS, and assets to `public/vendor/open-boost/`

### 3. Include in Your Blade Layout

In `resources/views/layouts/app.blade.php` (or your main layout):

**In `<head>`:**
```blade
<!-- CSS includes -->
<link href="{{ asset('vendor/open-boost/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/trix/trix.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/datatables.net/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/open-boost/assets/choices.js/choices.min.css') }}" rel="stylesheet">
```

**Before `</body>`:**
```blade
<!-- JavaScript includes (ORDER MATTERS: jQuery first, then libraries, then init) -->
<script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/quill/quill.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/datatables.net/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('vendor/open-boost/assets/trix/trix.js') }}"></script>
<!-- OpenBoost Init (auto-initializes all components) -->
<script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
```

**That's it!** Now use components:

```blade
<x-openBoost-select name="tags" lib="select2" theme="bootstrap">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

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

**Solution:** Ensure you've completed all 3 setup steps, especially:

1. ✅ **Published assets:**
   ```bash
   php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui
   ```

2. ✅ **Included jQuery BEFORE Select2/Choices:**
   ```blade
   <script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"></script>
   <!-- Then OpenBoost init -->
   <script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
   ```

3. ✅ **Check browser console** for errors:
   - Open DevTools (F12)
   - Look for red error messages about jQuery or Select2
   - The init script will log `Select2 initialized on: [element-id]` on success

**Common Issues:**
- `jQuery is not loaded` → Include jQuery before Select2
- `Select2 library is not loaded` → Include Select2 JS before init script
- Missing CSS → Include Select2 CSS in `<head>`

**Use the debug helper:**
```javascript
// Open browser console (F12) and run:
OpenBoost.debug()
```

This will show:
- ✅/❌ Which libraries are loaded
- How many components were found on the page
- Whether initialization is working

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