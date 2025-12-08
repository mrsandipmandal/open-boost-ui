# Auto-Loading Assets (New Method)

## How It Works

Instead of manually including script tags everywhere, you can now use two simple directives in your layout:

### Option 1: Automatic Asset Injection (Recommended)

In your main layout file (`resources/views/layouts/app.blade.php`):

**In the `<head>` section:**
```blade
@openBoostAssets
```

**Before `</body>`:**
```blade
@openBoostScripts
```

That's it! When you use a component:
```blade
<x-openBoost-select name="tags" lib="select2" theme="bootstrap">
    <option value="php">PHP</option>
</x-openBoost-select>
```

The component automatically:
1. Registers that it needs "select2"
2. The `@openBoostAssets` directive injects the CSS
3. The `@openBoostScripts` directive injects jQuery, Select2 JS, and init script

---

## Complete Example Layout

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS (or your CSS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- OpenBoost Auto-Assets (CSS) -->
    @openBoostAssets
    
    <style>
        body { padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        {{ $slot }}
    </div>

    <!-- Bootstrap JS (or your JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- OpenBoost Auto-Assets (Scripts) -->
    @openBoostScripts
</body>
</html>
```

---

## How Components Auto-Register

When you use a component like:

```blade
<x-openBoost-select name="tags" lib="select2">
    <option value="php">PHP</option>
</x-openBoost-select>
```

The component internally calls:
```php
\OpenBoost\UI\Services\AssetManager::require('select2');
```

This registers "select2" as a required library.

Then when the page renders:
- `@openBoostAssets` checks what's required and outputs only the needed CSS
- `@openBoostScripts` checks what's required and outputs only the needed JS

---

## Multiple Components

You can use multiple components and assets load once:

```blade
<x-openBoost-select name="tags" lib="select2">
    <option value="php">PHP</option>
</x-openBoost-select>

<x-openBoost-datepicker name="event_date" />

<x-openBoost-chart type="bar" :data="[...]" />
```

Result:
- CSS: select2.css, flatpickr.css, (chart.js has no CSS)
- JS: jquery, select2, flatpickr, chart.js, init script

All automatically! ✅

---

## Supported Libraries

When you use these libraries, they auto-load:

- `select2` → Select2 JS + CSS
- `choices` → Choices.js JS + CSS
- `flatpickr` → Flatpickr JS + CSS
- `quill` → Quill JS + CSS
- `simplemde` → SimpleMDE JS + CSS
- `trix` → Trix JS + CSS
- `apexcharts` → ApexCharts JS + CSS
- `chartjs` → Chart.js JS (no CSS)
- `datatables` → DataTables JS + CSS

---

## That's It!

No more manual script tags. Just:

1. Add `@openBoostAssets` in `<head>`
2. Add `@openBoostScripts` before `</body>`
3. Use components - everything loads automatically!

```blade
<x-openBoost-select name="tags" lib="select2" theme="bootstrap">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

✅ Works immediately!
