# Select Component - Usage Guide

## Overview
The `<x-openBoost-select>` component provides a flexible select dropdown with support for Select2 and Choices.js libraries.

## Basic Usage

### Method 1: Using Slot with HTML Options (Recommended)
```blade
<x-openBoost-select name="tags" lib="select2">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
    <option value="javascript">JavaScript</option>
</x-openBoost-select>
```

### Method 2: Using Options Array
```blade
@php
    $tags = [
        'php' => 'PHP',
        'laravel' => 'Laravel',
        'javascript' => 'JavaScript',
        'database' => 'Database'
    ];
@endphp

<x-openBoost-select 
    name="tags" 
    lib="select2"
    :options="$tags"
>
</x-openBoost-select>
```

### Method 3: With Custom Attributes
```blade
<x-openBoost-select 
    name="category" 
    lib="select2"
    :search="true"
    :multiple="true"
    class="custom-class"
>
    <option value="">Select category...</option>
    <option value="web">Web Development</option>
    <option value="mobile">Mobile Development</option>
    <option value="data">Data Science</option>
</x-openBoost-select>
```

## Available Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | auto-generated | Unique element ID |
| `name` | string | required | Form field name |
| `lib` | string | 'select2' | Library to use: 'select2' or 'choices' |
| `search` | boolean | true | Enable/disable search functionality |
| `multiple` | boolean | false | Allow multiple selections |
| `theme` | string | 'bootstrap' | Theme: 'bootstrap' or 'tailwind' |
| `options` | array | [] | PHP array of options ['value' => 'label'] |

## Library-Specific Options

### Select2 (Default)
Best for:
- Large datasets
- Advanced search features
- Custom templating
- AJAX-driven options

```blade
<x-openBoost-select 
    name="product" 
    lib="select2"
    :search="true"
    theme="bootstrap"
>
    <option value="">Choose a product...</option>
    <option value="1">Product A</option>
    <option value="2">Product B</option>
</x-openBoost-select>
```

### Choices.js
Best for:
- Lightweight alternative
- Modern browser support
- Custom value creation
- Simpler UI

```blade
<x-openBoost-select 
    name="skills" 
    lib="choices"
    :multiple="true"
    :search="true"
>
    <option value="">Select skills...</option>
    <option value="html">HTML</option>
    <option value="css">CSS</option>
    <option value="js">JavaScript</option>
</x-openBoost-select>
```

## Real-World Examples

### 1. Country Selector
```blade
<x-openBoost-select 
    name="country"
    lib="select2"
    class="mb-3"
>
    <option value="">-- Select Country --</option>
    <option value="us">United States</option>
    <option value="uk">United Kingdom</option>
    <option value="ca">Canada</option>
    <option value="au">Australia</option>
</x-openBoost-select>
```

### 2. Multiple Tags Selection
```blade
<x-openBoost-select 
    name="tags[]"
    lib="select2"
    :multiple="true"
    :search="true"
>
    <option value="urgent">Urgent</option>
    <option value="important">Important</option>
    <option value="follow-up">Follow-up</option>
    <option value="resolved">Resolved</option>
</x-openBoost-select>
```

### 3. Dynamic Options from Database
```blade
@php
    $departments = App\Models\Department::all()->pluck('name', 'id');
@endphp

<x-openBoost-select 
    name="department_id"
    lib="select2"
    :options="$departments"
/>
```

### 4. With Form Validation
```blade
<div class="form-group">
    <label for="role">Role</label>
    <x-openBoost-select 
        name="role"
        lib="select2"
        class="@error('role') border-red-500 @enderror"
    >
        <option value="">Select role...</option>
        <option value="admin">Administrator</option>
        <option value="editor">Editor</option>
        <option value="viewer">Viewer</option>
    </x-openBoost-select>
    @error('role')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
```

### 5. With Optgroups
```blade
<x-openBoost-select name="fruit" lib="select2">
    <option value="">Select fruit...</option>
    <optgroup label="Berries">
        <option value="strawberry">Strawberry</option>
        <option value="blueberry">Blueberry</option>
    </optgroup>
    <optgroup label="Citrus">
        <option value="orange">Orange</option>
        <option value="lemon">Lemon</option>
    </optgroup>
</x-openBoost-select>
```

## JavaScript Interaction

### Getting Selected Value
```javascript
// Get the value
const value = document.querySelector('[name="tags"]').value;
console.log('Selected:', value);

// With Select2 jQuery
jQuery('[name="tags"]').val(); // Single value
jQuery('[name="tags[]"]').val(); // Multiple values (array)
```

### Listening to Changes
```javascript
const select = document.querySelector('[name="tags"]');

// Native change event
select.addEventListener('change', (e) => {
    console.log('Selected value:', e.target.value);
});

// Select2 change event (if using Select2)
jQuery('[name="tags"]').on('change', function() {
    console.log('Select2 changed to:', jQuery(this).val());
});
```

### Programmatically Set Value
```javascript
// Native
document.querySelector('[name="tags"]').value = 'php';

// Select2
jQuery('[name="tags"]').val('php').trigger('change');

// Multiple values
jQuery('[name="tags[]"]').val(['php', 'laravel']).trigger('change');
```

### Clear Selection
```javascript
// Native
document.querySelector('[name="tags"]').value = '';

// Select2
jQuery('[name="tags"]').val(null).trigger('change');
```

## Debugging

### Check if Component is Initialized
```javascript
// In browser console
OpenBoost.debug();

// Should show:
// Select2: ✅ Loaded
// Components Found
// Selects: 1
```

### Common Issues

**Options not showing?**
- Verify Select2/jQuery are loaded before init script
- Check browser console for errors
- Ensure `@openBoostAssets` and `@openBoostScripts` are in layout

**Search not working?**
- Verify `search="true"` prop is set
- Check that Select2 library is loaded

**Style issues?**
- Add Select2 CSS: Include `@openBoostAssets` in head
- Verify Bootstrap/Tailwind CSS is loaded

## HTML Output Examples

### Basic Select with Options
```html
<select 
    id="openBoost-select-abc123"
    name="tags"
    data-openboost-select="true"
    data-openboost-select-lib="select2"
    data-openboost-select-search="1"
    data-openboost-select-theme="bootstrap-5"
    class="openBoost-select form-select w-full"
>
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</select>
```

### Multiple Select
```html
<select 
    id="openBoost-select-xyz789"
    name="tags[]"
    multiple
    data-openboost-select="true"
    data-openboost-select-lib="select2"
    data-openboost-select-search="1"
    class="openBoost-select form-select w-full"
>
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</select>
```

## Browser Support
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari 14+, Chrome Mobile 90+)

## Performance Notes
- Select2 lazy-loads for large option lists
- Use `search="false"` for small lists to reduce overhead
- For AJAX-driven options, consider Select2's built-in data method

## License
MIT - Part of OpenBoost UI component library
