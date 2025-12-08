# FlashJS Laravel UI

## Configuration

Located at:

```
config/flashjs.php
```

Example:

```php
return [
    'default_chart' => 'chartjs',
    'editor' => 'quill',
];
```

## Roadmap

- Accordion component
- Tabs component
- Tooltips and Notifications
- Carousel support
- Tailwind/Bootstrap Themes
- FullCalendar integration

## Contributing

Contributions are welcome. Feel free to submit a Pull Request for new UI components or improvements.

## License

MIT License © Sandip Mandal

## Additional Links
- [Code](https://github.com/mrsandipmandal/flashjs-laravel-ui)
- [Issues](https://github.com/mrsandipmandal/flashjs-laravel-ui/issues)
- [Pull requests](https://github.com/mrsandipmandal/flashjs-laravel-ui/pulls)
- [Actions](https://github.com/mrsandipmandal/flashjs-laravel-ui/actions)
- [Projects](https://github.com/mrsandipmandal/flashjs-laravel-ui/projects)
- [Security](https://github.com/mrsandipmandal/flashjs-laravel-ui/security)
- [Insights](https://github.com/mrsandipmandal/flashjs-laravel-ui/pulse)

## Installation

### Basic Installation

```bash
composer require open-boost/open-boost-ui
```

### Installation with All Libraries

```bash
composer require open-boost/open-boost-ui
php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui
```

This publishes assets to `resources/js/vendor/open-boost/`, config to `config/open-boost.php`, and views to `resources/views/vendor/boost/`.

## Usage Examples

### Dropdown

```blade
<x-flash-dropdown label="Menu">
    <a href="#">Profile</a>
    <a href="#">Logout</a>
</x-flash-dropdown>
```

### Modal

```blade
<x-flash-modal id="exampleModal" title="Demo Modal">
    Modal content goes here.
</x-flash-modal>

<button data-flash-modal-open="exampleModal">Open Modal</button>
```

### Select

```blade
<x-flash-select name="tags[]" multiple lib="choices">
    <option value="php">PHP</option>
    <option value="laravel">Laravel</option>
</x-flash-select>
```

### Datepicker

```blade
<x-flash-datepicker name="event_date" mode="single" />
```

### Chart

```blade
<x-flash-chart
    type="bar"
    :data="[
        'labels' => ['Jan', 'Feb', 'Mar'],
        'datasets' => [[ 'label' => 'Data', 'data' => [10,20,30] ]]
    ]"
/>
```

### Text Editor

```blade
<x-flash-editor name="content" engine="quill">
    {!! old('content') !!}
</x-flash-editor>
```

## Configuration

Located at `config/open-boost.php`

```php
return [
    'default_chart' => 'chartjs',
    'editor' => 'quill',
];
```

## Roadmap

- Accordion component
- Tabs component
- Tooltips and Notifications
- Carousel support
- Tailwind/Bootstrap Themes
- FullCalendar integration

## Contributing

Contributions are welcome. Feel free to submit a Pull Request for new UI components or improvements.

## License

MIT License
© Sandip Mandal