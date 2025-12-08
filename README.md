# Open Boost UI

## Configuration

Located at:
# Open Boost UI (open-boost/open-boost-ui)

Laravel Blade components and integrated frontend libraries (Select2, Choices, Flatpickr, Chart.js, ApexCharts, Quill, SimpleMDE, Trix, DataTables) with bundled assets — **no external npm/Composer dependencies needed**.

---

## Quick overview

During `composer require open-boost/open-boost-ui`, you will be prompted:
```
OpenBoost: do you want to download resources? [Y/N]
```

- **Answer Y** → Frontend assets are downloaded and configured into the package at `resources/assets/` (happens once during setup)
- **Answer N** → Skip resource configuration (can be done later with `php artisan openboost:install-resources`)

---

## Installation

### Step 1: Require the package

```powershell
composer require open-boost/open-boost-ui
```

### Step 2: Answer the prompt

When prompted, decide if you want to download and configure frontend resources **into the package**:

```
OpenBoost: do you want to download resources? [Y/N]
```

**Y** → Downloads frontend libraries (jQuery, Select2, Flatpickr, Charts, Editors, etc.) and configures them at:
```
open-boost-ui/
└── resources/
    └── assets/
        ├── jquery/
        ├── select2/
        ├── choices.js/
        ├── flatpickr/
        ├── chart.js/
        ├── apexcharts/
        ├── quill/
        ├── simplemde/
        ├── trix/
        └── datatables.net/
```

**N** → Skips resource download. You can configure later with:
```powershell
php artisan openboost:install-resources
```

---

## Bundled Assets Structure

After resources are configured, the package includes all frontend library files organized by library:

```
resources/assets/jquery/
├── jquery.min.js
└── jquery.js

resources/assets/select2/
├── select2.min.js
├── select2.min.css
├── select2.js
└── select2.css

... (and so on for all libraries)
```

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

### Dropdown

```blade
<x-boost-dropdown label="Menu">
    <a href="#">Profile</a>
    <a href="#">Logout</a>
</x-boost-dropdown>
```

### Modal

```blade
<x-boost-modal id="exampleModal" title="Demo Modal">
    Modal content goes here.
</x-boost-modal>

<button data-openBoost-modal-open="exampleModal">Open Modal</button>
```

### Select

```blade
<x-boost-select name="tags[]" multiple lib="choices">
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-boost-select>
```

### Datepicker

```blade
<x-boost-datepicker name="event_date" mode="single" />
```

### Chart

```blade
<x-boost-chart
    type="bar"
    :data="[
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [[ 'label' => 'Data', 'data' => [10,20,30] ]]
    ]"
/>
```

### Text Editor

```blade
<x-boost-editor name="content" engine="quill">
    {!! old('content') !!}
</x-boost-editor>
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