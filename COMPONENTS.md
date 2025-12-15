# OpenBoost UI Components

Professional, reusable Blade components for Laravel projects inspired by Alpine.js and modern component-driven UX patterns.

## Components Overview

### 1. Accordion
Collapsible accordion component with smooth transitions.

```blade
<x-openBoost-accordion :allowMultiple="false">
    <x-openBoost-accordionItem title="Section 1" :active="true">
        Content for section 1
    </x-openBoost-accordionItem>
    <x-openBoost-accordionItem title="Section 2">
        Content for section 2
    </x-openBoost-accordionItem>
</x-openBoost-accordion>
```

**Props:**
- `allowMultiple` (bool, default: false) - Allow multiple sections open at once
- `theme` (string, default: 'bootstrap') - Theme variant

---

### 2. Carousel
Auto-rotating carousel with navigation controls and indicators.

```blade
<x-openBoost-carousel :autoPlay="true" :interval="5000" :showIndicators="true">
    <x-openBoost-carouselSlide src="image1.jpg" alt="Slide 1" />
    <x-openBoost-carouselSlide src="image2.jpg" alt="Slide 2" />
    <x-openBoost-carouselSlide src="image3.jpg" alt="Slide 3" />
</x-openBoost-carousel>
```

**Props:**
- `autoPlay` (bool, default: false) - Enable auto-rotation
- `interval` (int, default: 5000) - Interval in milliseconds
- `showIndicators` (bool, default: true) - Show pagination dots

---

### 3. Tabs
Tabbed interface with content panels.

```blade
<x-openBoost-tabs>
    <x-openBoost-tab label="Overview" :active="true">
        Overview content here
    </x-openBoost-tab>
    <x-openBoost-tab label="Details">
        Detailed content here
    </x-openBoost-tab>
    <x-openBoost-tab label="Settings">
        Settings content here
    </x-openBoost-tab>
</x-openBoost-tabs>
```

**Props:**
- `theme` (string, default: 'bootstrap') - Theme variant

---

### 4. Radio Group
Grouped radio button inputs with optional horizontal layout.

```blade
<x-openBoost-radioGroup name="options" direction="vertical">
    <x-openBoost-radio value="option1" label="Option 1" :checked="true" />
    <x-openBoost-radio value="option2" label="Option 2" />
    <x-openBoost-radio value="option3" label="Option 3" />
</x-openBoost-radioGroup>
```

**Props:**
- `direction` (string, default: 'vertical') - Layout direction: 'vertical' or 'horizontal'
- `name` (string) - Radio button name attribute

---

### 5. Toggle
Animated toggle/switch component.

```blade
<x-openBoost-toggle 
    id="dark-mode" 
    label="Dark Mode" 
    :checked="false" 
/>
```

**Props:**
- `checked` (bool, default: false) - Initial state
- `label` (string) - Optional label text

---

### 6. Tooltip
Context-aware tooltip with positioning options.

```blade
<x-openBoost-tooltip text="Click to save" position="top">
    <button class="px-4 py-2 bg-blue-500 text-white rounded">
        Save
    </button>
</x-openBoost-tooltip>
```

**Props:**
- `text` (string) - Tooltip text
- `position` (string, default: 'top') - Position: 'top', 'bottom', 'left', 'right'

---

### 7. Datatable
Interactive data table with striped and hover effects.

```blade
<x-openBoost-datatable :striped="true" :hoverable="true" :bordered="true">
    <thead>
        <tr>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="px-4 py-2">{{ $user->name }}</td>
            <td class="px-4 py-2">{{ $user->email }}</td>
        </tr>
        @endforeach
    </tbody>
</x-openBoost-datatable>
```

**Props:**
- `striped` (bool, default: true) - Alternating row colors
- `hoverable` (bool, default: true) - Highlight on hover
- `bordered` (bool, default: true) - Show borders

---

### 8. List with Pagination
Paginated list component with automatic page navigation.

```blade
<x-openBoost-list :perPage="10">
    @foreach($items as $item)
    <x-openBoost-listItem value="{{ $item->id }}">
        {{ $item->name }}
    </x-openBoost-listItem>
    @endforeach
</x-openBoost-list>
```

**Props:**
- `perPage` (int, default: 10) - Items per page
- `theme` (string, default: 'bootstrap') - Theme variant

---

### 9. Notification
Dismissible alert notifications with auto-close option.

```blade
<x-openBoost-notification type="success" :dismissible="true" :autoClose="true" :closeDelay="5000">
    <strong>Success!</strong> Your action was completed successfully.
</x-openBoost-notification>

<x-openBoost-notification type="error">
    <strong>Error!</strong> Something went wrong.
</x-openBoost-notification>

<x-openBoost-notification type="warning">
    <strong>Warning!</strong> Please review the information.
</x-openBoost-notification>

<x-openBoost-notification type="info">
    <strong>Info:</strong> Check the details below.
</x-openBoost-notification>
```

**Props:**
- `type` (string, default: 'info') - Alert type: 'success', 'error', 'warning', 'info'
- `dismissible` (bool, default: true) - Show close button
- `autoClose` (bool, default: false) - Auto-dismiss after delay
- `closeDelay` (int, default: 5000) - Milliseconds before auto-close

---

## Installation

1. Add package to your Laravel project:
```bash
composer require open-boost/open-boost-ui
```

2. Publish assets:
```bash
php artisan vendor:publish --provider="OpenBoost\UI\OpenBoostServiceProvider" --tag=open-boost-ui
```

3. Include in your layout:
```blade
<head>
    @openBoostAssets
</head>
<body>
    <!-- Your content -->
    @openBoostScripts
</body>
```

---

## Browser Compatibility

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari 14+, Chrome Mobile 90+)

---

## Contributing

Contributions are welcome! Please ensure:
1. Components follow the existing naming convention (data-openboost-*)
2. JavaScript is vanilla (no external dependencies required)
3. Blade templates use professional styling
4. Documentation is updated with examples

---

## License

MIT License - See LICENSE.txt for details
