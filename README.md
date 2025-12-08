# Open Boost UI

## Configuration

Located at:
# Open Boost UI (open-boost/open-boost-ui)

Laravel Blade components and frontend integrations (Select2, Choices, Flatpickr, Chart.js, ApexCharts, Quill, SimpleMDE, Trix, DataTables, etc.) with an optional Composer plugin that assists installing and publishing frontend resources.

---

## Quick overview

- Install package with Composer.
- During installation the package can optionally copy bundled assets and attempt to install frontend packages used by the library.
- You control resource installation in three ways:
  - Environment variable: `OPENBOOST_RESOURCES=1` (one-off/session)
  - `composer.json` extra config in the consuming project: `extra.open-boost.install_resources = true` (persistent)
  - Interactive prompt: when none of the above are set and Composer is interactive, the plugin will ask Y/N during install.

Note: Composer does not accept unknown CLI flags, so `composer require open-boost/open-boost-ui --resources` will fail. Use one of the control methods above instead.

---

## Installation (recommended)

1) (Optional) Enable Asset Packagist in the consuming project so `npm-asset/*` packages can be resolved. Run this in PowerShell from your project folder:

```powershell
composer config repositories.asset-packagist composer https://asset-packagist.org
```

2) Install the package. You will be prompted if interactive and no explicit setting exists:

```powershell
composer require open-boost/open-boost-ui
```

When prompted:

- Answer `y` to copy the package's bundled resources into your project and to run the configured `composer require` for frontend packages (requires Asset Packagist or another asset repository).
- Answer `n` to skip resource installation — the package will still be installed (no frontend assets will be added).

3) Alternatively, enable automatic install by environment variable (one-off):

```powershell
# set env var for PowerShell session
$env:OPENBOOST_RESOURCES = '1'
composer require open-boost/open-boost-ui
```

4) Or persist the choice by adding to your consuming project's `composer.json` before requiring:

```json
"extra": {
  "open-boost": {
    "install_resources": true
  }
}
```

Then run:

```powershell
composer require open-boost/open-boost-ui
```

5) Composer plugin security prompt: when Composer sees a package with type `composer-plugin` it may ask to allow the plugin (writes to `allow-plugins` in `composer.json`). Approve it for the plugin to run.

---

## Local development / testing (use local package copy)

If you're developing the package locally and want your consuming project to use the workspace copy (so the plugin and `extra.class` you edited are used), add a path repository in the consuming project's folder:

```powershell
# from the consuming project folder
composer config repositories.open-boost path ../open-boost-ui
composer require open-boost/open-boost-ui:dev-master --prefer-source
```

This instructs Composer to use the local path instead of fetching from Packagist/GitHub.

---

## What the plugin does when resources are installed

- Copies the package `resources/` directory into `resources/open-boost` in your consuming project (this can be changed if you prefer `public/vendor/open-boost`).
- Reads `extra.open-boost.resource_packages` from the package `composer.json` and runs `composer require` for those package names (e.g. `npm-asset/select2`). This requires an asset repository such as Asset Packagist.

If you prefer not to have the plugin run external Composer commands, you can skip the prompt and/or not set the env/extra flag — the package will still be installed but the frontend assets won't be copied or fetched. If you'd like, open an issue or PR suggesting that the plugin copy to `public/vendor/open-boost` instead of `resources/open-boost` and I can change the default.

---

## Manual frontend install (recommended for modern apps)

Many Laravel apps manage frontend assets via npm/yarn and a bundler (Vite, Mix, etc.). If you prefer to manage frontend dependencies yourself, skip the plugin resource install and add the required packages with npm or yarn in your application:

```powershell
# npm
npm install jquery select2 choices.js flatpickr chart.js apexcharts quill simplemde trix datatables.net

# or yarn
yarn add jquery select2 choices.js flatpickr chart.js apexcharts quill simplemde trix datatables.net
```

Then import/build them with your normal frontend pipeline.

---

## Example usage (Blade components)

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