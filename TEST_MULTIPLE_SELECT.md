# Testing Multiple Select in Select2

## Quick Test Instructions

1. **Make sure CSS and JS are loaded:**
   - In your Blade layout, ensure you have `@openBoostAssets` in the `<head>` tag
   - And `@openBoostScripts` before `</body>` tag

2. **Test the component:**
```blade
<!-- This should now work with multiple selection -->
<x-openBoost-select name="tags[]" lib="select2" :multiple="true" :search="true">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>
```

## What Was Fixed

### JavaScript Changes (`open-boost-init.js`):
- ✅ Now detects `multiple` attribute properly
- ✅ Detects `name="tags[]"` and auto-enables multiple mode
- ✅ Destroys existing Select2 instances before re-initialization
- ✅ Sets `closeOnSelect: false` for multiple selects (keeps dropdown open)
- ✅ Proper initialization order ensures multiple mode is active

### CSS Changes (`open-boost.css`):
- ✅ Added custom styling for Select2 multiple selections
- ✅ Fixed width issues
- ✅ Styled selection tags/pills
- ✅ Improved dropdown appearance

### AssetManager Changes:
- ✅ Always includes `open-boost.css` for proper component styling
- ✅ Proper CDN fallback for all assets

## Browser Console Debugging

Open your browser's developer console (F12) and check:

```javascript
// This should show the select element details
document.querySelector('[data-openboost-select]')

// Check if it has the multiple attribute
document.querySelector('[data-openboost-select]').hasAttribute('multiple')

// Check Select2 initialization
console.log($('#your-select-id').data('select2'))
```

## Expected Behavior

When working correctly, you should see:
1. A search input field
2. Options showing with checkboxes (for multiple mode)
3. Selected items appearing as blue pills/tags
4. Ability to select multiple options
5. An "X" to remove selected items

## If Still Not Working

1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Hard refresh the page** (Ctrl+Shift+R)
3. **Check browser console** for any JavaScript errors
4. **Verify Bootstrap 5 CSS** is loaded (should be before @openBoostAssets)
5. **Check network tab** to ensure all resources loaded (especially CSS)

## Form Submission

When you submit the form with multiple selections:
- The `name="tags[]"` attribute ensures multiple values are sent as an array
- In PHP, you'll receive them as: `$_POST['tags']` (array)
- In Laravel: `$request->input('tags')` (array)

Example:
```php
// Laravel
$tags = $request->input('tags'); // ['php', 'laravel']

// Or in a form model
class YourModel extends Model {
    protected $fillable = ['tags']; // Cast as array if needed
    protected $casts = ['tags' => 'array'];
}
```
