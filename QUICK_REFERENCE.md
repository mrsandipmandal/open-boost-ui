# Quick Reference Card

## Installation (Same as Always)
```bash
composer require open-boost/open-boost-ui
# Answer Y to download resources

php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force
```

## New: Add to Your Layout

**In `<head>`:**
```blade
@openBoostAssets
```

**Before `</body>`:**
```blade
@openBoostScripts
```

## That's It!

Now use components:

```blade
<!-- Select2 auto-loads jquery + select2.js + select2.css -->
<x-openBoost-select name="tags" lib="select2">
    <option value="php">PHP</option>
</x-openBoost-select>

<!-- Flatpickr auto-loads jquery + flatpickr.js + flatpickr.css -->
<x-openBoost-datepicker name="date" />

<!-- Chart auto-loads jquery + chart.js -->
<x-openBoost-chart type="bar" :data="$data" />

<!-- Quill auto-loads jquery + quill.js + quill.css -->
<x-openBoost-editor name="content" engine="quill" />
```

✅ Assets load automatically based on components used!

---

## Minimum Layout

```blade
<!DOCTYPE html>
<html>
<head>
    <title>App</title>
    @openBoostAssets
</head>
<body>
    {{ $slot }}
    @openBoostScripts
</body>
</html>
```

---

## Supported Libraries

| Component | Libraries |
|-----------|-----------|
| Select | `select2`, `choices` |
| Datepicker | `flatpickr` |
| Chart | `chartjs`, `apexcharts` |
| Editor | `quill`, `simplemde`, `trix` |

---

## Debug

```javascript
// In browser console:
OpenBoost.debug()

// Shows what loaded ✅/❌
```

---

## Done!

Just:
1. Add 2 directives to layout
2. Use components
3. Assets load automatically!

🚀 No more manual script tags!
