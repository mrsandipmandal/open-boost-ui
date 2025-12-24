# jQuery Setup Guide for OpenBoost UI

## Problem
External libraries like DataTables, jsTree, and Form Wizard require jQuery to be loaded and available globally as `$` or `jQuery` before they initialize. Without proper setup, you'll see errors like:

- `Cannot read properties of undefined (reading 'extend')` - DataTables
- `ReferenceError: $ is not defined` - Form Wizard, jsTree
- `Cannot read properties of undefined (reading 'jstree')` - jsTree

## Solution: Proper Script Loading Order

Your HTML page must load scripts in this exact order:

### 1. jQuery First (Required for all plugins)
```html
<script src="/path/to/jquery.min.js"></script>
```

### 2. jQuery Plugins (In any order)
Load any jQuery-dependent plugins you need:
```html
<!-- DataTables with Bootstrap 5 -->
<link rel="stylesheet" href="/path/to/datatables.min.css">
<script src="/path/to/datatables.min.js"></script>

<!-- jsTree -->
<link rel="stylesheet" href="/path/to/jstree.min.css">
<script src="/path/to/jstree.min.js"></script>

<!-- Form Wizard -->
<script src="/path/to/form-wizard-numbered.js"></script>
<script src="/path/to/form-wizard-validation.js"></script>

<!-- Extended UI -->
<script src="/path/to/extended-ui-treeview.js"></script>
```

### 3. Other Required Libraries
```html
<!-- Select2 -->
<link rel="stylesheet" href="/path/to/select2.min.css">
<script src="/path/to/select2.min.js"></script>

<!-- Choices.js -->
<link rel="stylesheet" href="/path/to/choices.min.css">
<script src="/path/to/choices.min.js"></script>

<!-- Flatpickr -->
<link rel="stylesheet" href="/path/to/flatpickr.min.css">
<script src="/path/to/flatpickr.min.js"></script>

<!-- Chart.js -->
<script src="/path/to/chart.min.js"></script>

<!-- ApexCharts -->
<script src="/path/to/apexcharts.min.js"></script>

<!-- Quill Editor -->
<link rel="stylesheet" href="/path/to/quill.snow.css">
<script src="/path/to/quill.min.js"></script>

<!-- SimpleMDE Editor -->
<link rel="stylesheet" href="/path/to/simplemde.min.css">
<script src="/path/to/simplemde.min.js"></script>

<!-- Trix Editor -->
<link rel="stylesheet" href="/path/to/trix.css">
<script src="/path/to/trix.js"></script>
```

### 4. OpenBoost Initialization Script (LAST)
```html
<!-- OpenBoost CSS (can go in <head> or <body>) -->
<link rel="stylesheet" href="/path/to/open-boost.css">

<!-- OpenBoost Initialization Script (MUST be last) -->
<script src="/path/to/open-boost-init.js"></script>
```

## Complete Example HTML Structure

```html
<!DOCTYPE html>
<html>
<head>
    <!-- CSS Files -->
    <link rel="stylesheet" href="datatables.min.css">
    <link rel="stylesheet" href="select2.min.css">
    <link rel="stylesheet" href="choices.min.css">
    <link rel="stylesheet" href="flatpickr.min.css">
    <link rel="stylesheet" href="quill.snow.css">
    <link rel="stylesheet" href="simplemde.min.css">
    <link rel="stylesheet" href="trix.css">
    <link rel="stylesheet" href="open-boost.css">
</head>
<body>
    <!-- Your HTML content here -->

    <!-- JavaScript Files in Correct Order -->
    <!-- 1. jQuery FIRST -->
    <script src="jquery.min.js"></script>

    <!-- 2. jQuery Plugins (depends on jQuery being loaded) -->
    <script src="datatables.min.js"></script>
    <script src="jstree.min.js"></script>
    <script src="form-wizard-numbered.js"></script>
    <script src="form-wizard-validation.js"></script>
    <script src="extended-ui-treeview.js"></script>

    <!-- 3. Other standalone libraries -->
    <script src="select2.min.js"></script>
    <script src="choices.min.js"></script>
    <script src="flatpickr.min.js"></script>
    <script src="chart.min.js"></script>
    <script src="apexcharts.min.js"></script>
    <script src="quill.min.js"></script>
    <script src="simplemde.min.js"></script>
    <script src="trix.js"></script>

    <!-- 4. OpenBoost LAST (initializes all OpenBoost components) -->
    <script src="open-boost-init.js"></script>
</body>
</html>
```

## Troubleshooting

### If you still get jQuery errors:

1. **Check jQuery is loaded:**
   Open browser console and run:
   ```javascript
   console.log(typeof jQuery)  // Should be 'function'
   console.log(typeof $)       // Should be 'function'
   ```

2. **Manually expose jQuery:**
   If jQuery loads but `$` is not defined, run in console:
   ```javascript
   window.ensureJQuery()  // This will expose $ and jQuery globally
   ```

3. **Check script URLs:**
   Make sure all script paths in your HTML are correct and files actually exist.

4. **Check console for load errors:**
   Look for 404 errors or CORS errors on specific scripts.

5. **Use OpenBoost Debug Helper:**
   ```javascript
   OpenBoost.debug()  // Shows what dependencies are loaded
   ```

## What OpenBoost Does

When `open-boost-init.js` loads:

1. ✅ Automatically exposes jQuery as `window.$` and `window.jQuery` (if not already exposed)
2. ✅ Waits for DOM to be ready before initializing components
3. ✅ Provides `window.ensureJQuery()` function to manually expose jQuery
4. ✅ Initializes all OpenBoost components with proper error handling
5. ✅ Provides `OpenBoost.debug()` method to check what loaded successfully

## OpenBoost Components Initialized

When `OpenBoost.initAll()` runs (automatically on DOM ready), it initializes:

- **Dropdowns** - `[data-openboost-dropdown]`
- **Modals** - `[data-openboost-modal]`
- **Select Boxes** - `[data-openboost-select]`
- **Datepickers** - `[data-openboost-datepicker]`
- **Charts** - `[data-openboost-chart]`
- **Editors** - `[data-openboost-editor]`
- **Accordions** - `[data-openboost-accordion]`
- **Carousels** - `[data-openboost-carousel]`
- **Tabs** - `[data-openboost-tabs]`
- **Radio Groups** - `[data-openboost-radiogroup]`
- **Toggles** - `[data-openboost-toggle]`
- **Tooltips** - `[data-openboost-tooltip]`
- **Notifications** - `[data-openboost-notification]`
- **DataTables** - `[data-openboost-datatable]`
- **Lists** - `[data-openboost-list]`

## Need Help?

Run this in your browser console to see what's working:
```javascript
OpenBoost.debug()
```

This will show you:
- ✅/❌ Which dependencies are loaded
- Count of each OpenBoost component found on the page
