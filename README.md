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

## 📚 Component Library

### Form Components

#### 1️⃣ **Select** - Flexible Dropdown Input
**Best for:** Choosing single/multiple options, autocomplete, large datasets

```blade
<!-- Basic Select -->
<x-openBoost-select name="category" lib="select2">
    <option value="">Select category...</option>
    <option value="web">Web Development</option>
    <option value="mobile">Mobile Development</option>
</x-openBoost-select>

<!-- Multiple Selection -->
<x-openBoost-select name="tags[]" lib="select2" :multiple="true" :search="true">
    <option value="">Select tags...</option>
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-openBoost-select>

<!-- Array-Based Options -->
@php
    $options = ['php' => 'PHP', 'laravel' => 'Laravel', 'js' => 'JavaScript'];
@endphp
<x-openBoost-select name="lang" lib="choices" :options="$options" />
```

**Props:**
- `lib` - 'select2' or 'choices' (default: 'select2')
- `search` - Enable search (default: true)
- `multiple` - Allow multiple selections
- `theme` - 'bootstrap' or 'tailwind'

**Libraries:**
- **Select2** - Advanced features, large datasets, AJAX support
- **Choices.js** - Lightweight, modern, custom value creation

---

#### 2️⃣ **Datepicker** - Date/Time Selection
**Best for:** Booking systems, event dates, time tracking, form submissions

```blade
<!-- Single Date -->
<x-openBoost-datepicker name="event_date" mode="single" />

<!-- Date Range -->
<x-openBoost-datepicker name="date_range" mode="range" />

<!-- With Time -->
<x-openBoost-datepicker name="event_time" :enableTime="true" />

<!-- Multiple Dates -->
<x-openBoost-datepicker name="holidays" mode="multiple" />
```

**Props:**
- `mode` - 'single', 'range', 'multiple' (default: 'single')
- `enableTime` - Include time picker
- `lib` - Currently supports 'flatpickr'

**Use Cases:**
- Booking appointments
- Meeting scheduling
- Event registration
- Deadline tracking

---

#### 3️⃣ **Radio Group** - Exclusive Option Selection
**Best for:** Binary choices, preference selection, survey questions

```blade
<!-- Vertical Layout -->
<x-openBoost-radioGroup name="theme" direction="vertical">
    <x-openBoost-radio value="light" label="Light Theme" :checked="true" />
    <x-openBoost-radio value="dark" label="Dark Theme" />
    <x-openBoost-radio value="auto" label="Auto (System)" />
</x-openBoost-radioGroup>

<!-- Horizontal Layout -->
<x-openBoost-radioGroup name="priority" direction="horizontal">
    <x-openBoost-radio value="low" label="Low" />
    <x-openBoost-radio value="medium" label="Medium" :checked="true" />
    <x-openBoost-radio value="high" label="High" />
</x-openBoost-radioGroup>
```

**Props:**
- `direction` - 'vertical' or 'horizontal'
- `name` - Form field name (required)

---

#### 4️⃣ **Toggle** - Boolean Switch
**Best for:** Feature flags, settings, enable/disable options

```blade
<!-- Basic Toggle -->
<x-openBoost-toggle id="notifications" label="Enable Notifications" :checked="true" />

<!-- Dark Mode Toggle -->
<x-openBoost-toggle id="dark-mode" label="Dark Mode" :checked="false" />

<!-- Without Label -->
<x-openBoost-toggle id="newsletter" :checked="true" />
```

**Props:**
- `checked` - Initial state (true/false)
- `label` - Optional label text
- `id` - Unique identifier (required)

**Use Cases:**
- Settings preferences
- Feature toggles
- Newsletter subscriptions
- Privacy settings

---

### Data Display Components

#### 5️⃣ **Datatable** - Structured Data Display
**Best for:** Displaying records, admin panels, data management interfaces

```blade
<x-openBoost-datatable :striped="true" :hoverable="true" :bordered="true">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="px-4 py-2">{{ $user->name }}</td>
            <td class="px-4 py-2">{{ $user->email }}</td>
            <td class="px-4 py-2">
                <span class="px-2 py-1 rounded text-sm {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-gray-100' }}">
                    {{ $user->active ? 'Active' : 'Inactive' }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</x-openBoost-datatable>
```

**Props:**
- `striped` - Alternating row colors
- `hoverable` - Highlight on hover
- `bordered` - Show borders

---

#### 6️⃣ **List with Pagination** - Paginated Item List
**Best for:** Blog posts, product listings, user directories

```blade
<x-openBoost-list :perPage="10">
    @foreach($posts as $post)
    <x-openBoost-listItem value="{{ $post->id }}">
        <div>
            <h3 class="font-semibold">{{ $post->title }}</h3>
            <p class="text-sm text-gray-600">{{ $post->excerpt }}</p>
        </div>
    </x-openBoost-listItem>
    @endforeach
</x-openBoost-list>
```

**Props:**
- `perPage` - Items per page (default: 10)
- `theme` - 'bootstrap' or 'tailwind'

---

### Layout & Navigation Components

#### 7️⃣ **Accordion** - Collapsible Content Sections
**Best for:** FAQs, feature lists, expandable content, documentation

```blade
<x-openBoost-accordion :allowMultiple="false">
    <x-openBoost-accordionItem title="What is OpenBoost?" :active="true">
        OpenBoost is a professional Blade component library for Laravel with 15+ pre-built components.
    </x-openBoost-accordionItem>
    
    <x-openBoost-accordionItem title="How to install?">
        Simply run: <code>composer require open-boost/open-boost-ui</code>
    </x-openBoost-accordionItem>
    
    <x-openBoost-accordionItem title="Is it free?">
        Yes! OpenBoost is MIT licensed and completely free.
    </x-openBoost-accordionItem>
</x-openBoost-accordion>
```

**Props:**
- `allowMultiple` - Allow multiple open sections (default: false)
- `theme` - 'bootstrap' or 'tailwind'

**Use Cases:**
- FAQ pages
- Documentation
- Product features
- Pricing tiers

---

#### 8️⃣ **Carousel** - Image/Content Slider
**Best for:** Image galleries, testimonials, hero sections, featured content

```blade
<x-openBoost-carousel :autoPlay="true" :interval="5000" :showIndicators="true">
    <x-openBoost-carouselSlide src="image1.jpg" alt="Slide 1" />
    <x-openBoost-carouselSlide src="image2.jpg" alt="Slide 2" />
    <x-openBoost-carouselSlide src="image3.jpg" alt="Slide 3" />
</x-openBoost-carousel>
```

**Props:**
- `autoPlay` - Auto-rotate slides
- `interval` - Rotation interval in ms (default: 5000)
- `showIndicators` - Show pagination dots

---

#### 9️⃣ **Tabs** - Tabbed Content
**Best for:** Product features, documentation sections, user profiles

```blade
<x-openBoost-tabs>
    <x-openBoost-tab label="Overview" :active="true">
        <h3>Product Overview</h3>
        <p>This is the overview tab content...</p>
    </x-openBoost-tab>
    
    <x-openBoost-tab label="Features">
        <ul class="list-disc">
            <li>Feature 1</li>
            <li>Feature 2</li>
        </ul>
    </x-openBoost-tab>
    
    <x-openBoost-tab label="Pricing">
        <table>
            <tr><td>Basic</td><td>$9/mo</td></tr>
            <tr><td>Pro</td><td>$29/mo</td></tr>
        </table>
    </x-openBoost-tab>
</x-openBoost-tabs>
```

---

### Feedback & Messaging Components

#### 🔟 **Notification** - Alert Messages
**Best for:** Status messages, confirmations, warnings, errors

```blade
<!-- Success Message -->
<x-openBoost-notification type="success" :dismissible="true">
    <strong>Success!</strong> Your changes have been saved.
</x-openBoost-notification>

<!-- Error Message -->
<x-openBoost-notification type="error">
    <strong>Error!</strong> Something went wrong.
</x-openBoost-notification>

<!-- Warning Message -->
<x-openBoost-notification type="warning">
    <strong>Warning!</strong> Please review your input.
</x-openBoost-notification>

<!-- Auto-closing Notification -->
<x-openBoost-notification type="info" :autoClose="true" :closeDelay="3000">
    <strong>Info:</strong> New updates available.
</x-openBoost-notification>
```

**Props:**
- `type` - 'success', 'error', 'warning', 'info'
- `dismissible` - Show close button
- `autoClose` - Auto-dismiss after delay
- `closeDelay` - Milliseconds before auto-close

---

#### 1️⃣1️⃣ **Tooltip** - Contextual Help
**Best for:** Inline help, UI hints, button descriptions

```blade
<x-openBoost-tooltip text="Save your progress" position="top">
    <button class="px-4 py-2 bg-blue-500 text-white rounded">
        Save
    </button>
</x-openBoost-tooltip>

<x-openBoost-tooltip text="Delete permanently" position="right">
    <button class="px-4 py-2 bg-red-500 text-white rounded">
        Delete
    </button>
</x-openBoost-tooltip>
```

**Props:**
- `text` - Tooltip text
- `position` - 'top', 'bottom', 'left', 'right'

---

### Modal & Dropdown Components

#### 1️⃣2️⃣ **Modal** - Dialog Box
**Best for:** Confirmations, forms, alerts, detailed content

```blade
<!-- Modal Definition -->
<x-openBoost-modal id="deleteModal" title="Confirm Deletion">
    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
    <div class="flex gap-2 mt-4">
        <button data-openBoost-modal-close class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
        <form method="POST" action="/items/{{ $item->id }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Delete</button>
        </form>
    </div>
</x-openBoost-modal>

<!-- Trigger Button -->
<button data-openBoost-modal-open="deleteModal" class="px-4 py-2 bg-red-600 text-white rounded">
    Delete Item
</button>
```

---

#### 1️⃣3️⃣ **Dropdown** - Action Menu
**Best for:** Navigation menus, action buttons, context menus

```blade
<x-openBoost-dropdown label="Actions">
    <a href="/users/{{ $user->id }}/edit" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
    <a href="/users/{{ $user->id }}/profile" class="block px-4 py-2 hover:bg-gray-100">View Profile</a>
    <hr class="my-2">
    <a href="/users/{{ $user->id }}/delete" class="block px-4 py-2 text-red-600 hover:bg-red-50">Delete</a>
</x-openBoost-dropdown>
```

---

### Media & Data Visualization Components

#### 1️⃣4️⃣ **Chart** - Data Visualization
**Best for:** Analytics dashboards, reporting, data comparison

```blade
<!-- Bar Chart -->
<x-openBoost-chart 
    type="bar"
    :data="[
        'labels' => ['January', 'February', 'March', 'April'],
        'datasets' => [
            [
                'label' => 'Sales',
                'data' => [12, 19, 3, 5],
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
            ]
        ]
    ]"
/>

<!-- Line Chart -->
<x-openBoost-chart 
    type="line"
    engine="chartjs"
    :data="[
        'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        'datasets' => [
            [
                'label' => 'Revenue',
                'data' => [1000, 1500, 1200, 2000],
                'borderColor' => 'rgb(75, 192, 192)',
            ]
        ]
    ]"
/>
```

**Props:**
- `type` - 'bar', 'line', 'pie', 'doughnut', 'radar'
- `engine` - 'chartjs' or 'apexcharts'

**Supported Libraries:**
- **Chart.js** - Simple, responsive charts
- **ApexCharts** - Interactive, feature-rich charts

---

#### 1️⃣5️⃣ **Editor** - Rich Text Editing
**Best for:** Blog posts, documentation, content management

```blade
<!-- Quill Editor (Recommended) -->
<x-openBoost-editor name="content" engine="quill">
    {!! old('content') !!}
</x-openBoost-editor>

<!-- SimpleMDE Markdown Editor -->
<x-openBoost-editor name="markdown" engine="simplemde">
    {!! old('markdown') !!}
</x-openBoost-editor>

<!-- Trix Editor -->
<x-openBoost-editor name="description" engine="trix">
    {!! old('description') !!}
</x-openBoost-editor>
```

**Props:**
- `engine` - 'quill', 'simplemde', or 'trix'

**Editor Comparison:**
| Editor | Best For | Learning Curve |
|--------|----------|-----------------|
| Quill | WYSIWYG editing, most features | Low |
| SimpleMDE | Markdown content | Low |
| Trix | Rails-like experience | Medium |

---

## 🎯 Common Use Cases & Examples

### Case 1: User Management Form
```blade
<form method="POST" action="/users">
    @csrf
    
    <div class="mb-4">
        <label>Department</label>
        <x-openBoost-select name="department_id" lib="select2">
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </x-openBoost-select>
    </div>
    
    <div class="mb-4">
        <label>Role</label>
        <x-openBoost-radioGroup name="role">
            <x-openBoost-radio value="admin" label="Administrator" />
            <x-openBoost-radio value="user" label="User" :checked="true" />
            <x-openBoost-radio value="guest" label="Guest" />
        </x-openBoost-radioGroup>
    </div>
    
    <div class="mb-4">
        <label>Receive Notifications</label>
        <x-openBoost-toggle id="notifications" :checked="true" />
    </div>
    
    <button type="submit">Create User</button>
</form>
```

### Case 2: Product Showcase Dashboard
```blade
<x-openBoost-tabs>
    <!-- Overview Tab -->
    <x-openBoost-tab label="Overview" :active="true">
        <x-openBoost-chart type="line" :data="$salesData" />
    </x-openBoost-tab>
    
    <!-- Products Tab -->
    <x-openBoost-tab label="Products">
        <x-openBoost-datatable>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>${{ $product->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </x-openBoost-datatable>
    </x-openBoost-tab>
</x-openBoost-tabs>
```

### Case 3: Blog Post Editor
```blade
<form method="POST" action="/posts" enctype="multipart/form-data">
    @csrf
    
    <input type="text" name="title" placeholder="Post Title" class="form-control mb-3">
    
    <div class="mb-3">
        <label>Category</label>
        <x-openBoost-select name="category_id" lib="select2" :options="$categories" />
    </div>
    
    <div class="mb-3">
        <label>Tags</label>
        <x-openBoost-select name="tags[]" lib="select2" :multiple="true" :options="$tags" />
    </div>
    
    <div class="mb-3">
        <label>Content</label>
        <x-openBoost-editor name="content" engine="quill" />
    </div>
    
    <div class="mb-3">
        <label>Publish Date</label>
        <x-openBoost-datepicker name="published_at" :enableTime="true" />
    </div>
    
    <button type="submit" class="btn btn-primary">Publish</button>
</form>
```

---

## 🔧 Configuration

### Environment-Specific Themes

In `resources/views/layouts/app.blade.php`:

```blade
@php
    $theme = config('app.ui_theme', 'bootstrap'); // bootstrap or tailwind
@endphp

<x-openBoost-select name="category" theme="{{ $theme }}" />
```

### Global Configuration

Edit `config/open-boost.php`:

```php
return [
    'default_theme' => 'bootstrap', // or 'tailwind'
    'default_chart' => 'chartjs',   // or 'apexcharts'
    'default_editor' => 'quill',    // or 'simplemde', 'trix'
    'animations_enabled' => true,
];
```

---

## 📖 Advanced Usage

### JavaScript API

#### Initialize Components Manually
```javascript
// Re-initialize components (useful for dynamically added content)
OpenBoost.initAll();

// Or initialize specific component type
OpenBoost.initSelects();
OpenBoost.initDatepickers();
OpenBoost.initAccordions();
```

#### Get Component References
```javascript
// Get Select2 instance
const select = document.querySelector('[name="category"]');
jQuery(select).select2('open');

// Get Flatpickr instance
const datepicker = document.querySelector('[name="event_date"]');
flatpickr(datepicker).show();
```

#### Listen to Component Events
```javascript
// Select2 change event
jQuery('[name="tags"]').on('change', function() {
    const selected = jQuery(this).val();
    console.log('Selected:', selected);
});

// Datepicker change event
flatpickr('[name="event_date"]', {
    onChange: (selectedDates) => {
        console.log('Date changed:', selectedDates);
    }
});

// Accordion item toggle
document.addEventListener('click', (e) => {
    if (e.target.matches('[data-openboost-accordion-trigger]')) {
        console.log('Accordion toggled');
    }
});
```

#### Debug Helper
```javascript
// In browser console
OpenBoost.debug();

// Output:
// 🔍 OpenBoost Debug Info
// Dependencies
// jQuery ($): ✅ Loaded
// Select2: ✅ Loaded
// Flatpickr: ✅ Loaded
// ...
// Components Found
// Selects: 2
// Datepickers: 1
// ...
```

---

### Custom Styling & Theming

#### Override Default Classes
```blade
<!-- Custom classes merge with defaults -->
<x-openBoost-select 
    name="status" 
    class="custom-select border-2 border-blue-500"
>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</x-openBoost-select>
```

#### Create Custom Theme
```blade
<!-- Custom styled accordion -->
<x-openBoost-accordion>
    <x-openBoost-accordionItem title="Section 1" :active="true">
        <div class="bg-blue-50 p-4">Custom styled content</div>
    </x-openBoost-accordionItem>
</x-openBoost-accordion>
```

#### Tailwind CSS Configuration
```html
<!-- Use Tailwind utility classes -->
<x-openBoost-toggle 
    id="feature" 
    label="Enable Feature"
    class="ring-2 ring-offset-2 ring-blue-500"
/>
```

---

### Form Integration

#### Validation Integration
```blade
<form method="POST" action="/process">
    @csrf
    
    <div class="form-group">
        <label for="category">Category</label>
        <x-openBoost-select 
            name="category_id"
            lib="select2"
            class="@error('category_id') border-red-500 @enderror"
        >
            <option value="">Select category...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </x-openBoost-select>
        @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <button type="submit">Submit</button>
</form>
```

#### Pre-fill Form Data
```blade
<!-- Old data restoration -->
<x-openBoost-select name="role" lib="select2">
    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
    <option value="user" @selected(old('role') === 'user')>User</option>
</x-openBoost-select>

<!-- Datepicker with date -->
<x-openBoost-datepicker 
    name="birth_date" 
    value="{{ old('birth_date', auth()->user()->birth_date ?? '') }}"
/>

<!-- Toggle persistence -->
<x-openBoost-toggle 
    id="newsletter"
    :checked="(bool) old('subscribe_newsletter', auth()->user()?->subscribe_newsletter)"
/>
```

---

### Dynamic Content

#### Load Options via AJAX
```blade
<x-openBoost-select name="subcategory" id="subcat-select" lib="select2">
    <option value="">Select subcategory...</option>
</x-openBoost-select>

<script>
// Fetch and populate on category change
document.querySelector('[name="category"]').addEventListener('change', async function() {
    const categoryId = this.value;
    const response = await fetch(`/api/categories/${categoryId}/subcategories`);
    const subcategories = await response.json();
    
    const select = document.querySelector('#subcat-select');
    select.innerHTML = '<option value="">Select subcategory...</option>';
    
    subcategories.forEach(sub => {
        const option = document.createElement('option');
        option.value = sub.id;
        option.textContent = sub.name;
        select.appendChild(option);
    });
    
    // Reinitialize Select2
    jQuery(select).select2();
});
</script>
```

#### Add Items to Pagination List
```blade
<x-openBoost-list id="posts-list" :perPage="5">
    @foreach($posts as $post)
    <x-openBoost-listItem>
        <h4>{{ $post->title }}</h4>
    </x-openBoost-listItem>
    @endforeach
</x-openBoost-list>

<script>
// Add new item dynamically
const listContainer = document.querySelector('[data-openboost-list-items]');
const newItem = document.createElement('li');
newItem.innerHTML = '<div data-openboost-list-item>New Post Title</div>';
listContainer.appendChild(newItem);

// Reinitialize list pagination
OpenBoost.initLists();
</script>
```

---

## 🚨 Troubleshooting

### Components Not Rendering
**Error:** `Unable to locate a class or view for component [openBoost-*]`

**Solution:**
1. Ensure service provider is auto-discovered or registered in `config/app.php`
2. Run: `php artisan cache:clear && php artisan view:clear`
3. Verify views are published: `resources/views/vendor/boost/components/openBoost/`

### Select2/Choices Not Working
**Error:** Options appear but dropdown doesn't work

**Solution:**
1. Verify jQuery is included before Select2
2. Check browser console for JavaScript errors
3. Run `OpenBoost.debug()` in console to check library status
4. Ensure `@openBoostScripts` is included before `</body>`

```blade
<!-- CORRECT ORDER -->
<head>
    @openBoostAssets
</head>
<body>
    <!-- Your content -->
    @openBoostScripts  <!-- Must be last, before </body> -->
</body>
```

### Datepicker Not Showing Calendar
**Error:** Input renders but calendar doesn't appear on click

**Solution:**
1. Include Flatpickr CSS in `@openBoostAssets`
2. Verify `flatpickr.min.js` is loaded
3. Check for JavaScript errors in console
4. Ensure Flatpickr CSS path is correct

### Components Styles Broken
**Error:** Components render but styling looks off

**Solution:**
1. Include Bootstrap/Tailwind CSS in layout
2. Add `@openBoostAssets` in `<head>`
3. Check theme is set correctly: `theme="bootstrap"` or `theme="tailwind"`
4. Verify CSS files are being served from `public/vendor/open-boost/`

### Performance Issues
**Slow page load or responsiveness issues**

**Solutions:**
1. Defer component initialization:
   ```blade
   <script defer src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"></script>
   ```

2. Lazy-load heavy components:
   ```blade
   @if($showChart)
       <x-openBoost-chart :data="$chartData" />
   @endif
   ```

3. Use `search="false"` for selects without search:
   ```blade
   <x-openBoost-select name="status" lib="select2" :search="false">
   ```

---

## 🔐 Security Considerations

### CSRF Protection
All components automatically respect Laravel's CSRF token:

```blade
<!-- Form with CSRF protection -->
<form method="POST" action="/submit">
    @csrf
    <x-openBoost-select name="option">...</x-openBoost-select>
    <button>Submit</button>
</form>
```

### XSS Protection
Component content is automatically escaped. For raw HTML:

```blade
<!-- This is escaped -->
<x-openBoost-notification type="success">
    {{ $message }}
</x-openBoost-notification>

<!-- Use {!! !!} only for trusted content -->
<x-openBoost-notification type="info">
    {!! $trusted_html !!}
</x-openBoost-notification>
```

### Input Validation
Always validate component values server-side:

```php
// controller
$validated = $request->validate([
    'category_id' => 'required|exists:categories,id',
    'tags' => 'array|exists:tags,id',
    'event_date' => 'required|date_format:Y-m-d',
]);
```

---

## 📊 Supported Versions

| Laravel | PHP | Support |
|---------|-----|---------|
| 9.x | 8.0+ | ✅ Full |
| 10.x | 8.1+ | ✅ Full |
| 11.x | 8.2+ | ✅ Full |

---

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

### Development Setup
```bash
git clone https://github.com/mrsandipmandal/open-boost-ui.git
cd open-boost-ui

# Create test Laravel app
composer require laravel/laravel test-app
cd test-app

# Link local package
composer config repositories.open-boost path ../open-boost-ui
composer require open-boost/open-boost-ui:dev-master --prefer-source
```

### Running Tests
```bash
php artisan test
```

---

## 📝 Component Checklist

- [x] Accordion
- [x] Carousel
- [x] Chart
- [x] Datepicker
- [x] Datatable
- [x] Dropdown
- [x] Editor (Quill, SimpleMDE, Trix)
- [x] List with Pagination
- [x] Modal
- [x] Notification
- [x] Radio Group
- [x] Select (Select2, Choices)
- [x] Tabs
- [x] Toggle
- [x] Tooltip

---

## 📄 License

MIT License © 2024 [Sandip Mandal](https://github.com/mrsandipmandal). See [LICENSE.txt](LICENSE.txt).

---

## 🙏 Credits

Built with modern best practices inspired by:
- [Laravel Blade Components](https://laravel.com/docs/blade#components)
- [Tailwind CSS](https://tailwindcss.com)
- [Bootstrap 5](https://getbootstrap.com/)
- Select2, Flatpickr, Chart.js, and other amazing open-source libraries

---

## 📞 Support & Resources

- 📖 [Full Documentation](COMPONENTS.md)
- 🐛 [Report Issues](https://github.com/mrsandipmandal/open-boost-ui/issues)
- 💬 [Discussions](https://github.com/mrsandipmandal/open-boost-ui/discussions)
- 📦 [Packagist](https://packagist.org/packages/open-boost/open-boost-ui)

---

**Made with ❤️ for the Laravel community**