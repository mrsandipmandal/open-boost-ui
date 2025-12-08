@echo off
REM ========================================
REM Open Boost UI - Setup Script (Windows)
REM ========================================
REM Run this after installing open-boost/open-boost-ui

echo.
echo ========================================
echo Open Boost UI - Complete Setup
echo ========================================
echo.

REM Step 1: Publish Assets
echo Step 1: Publishing assets to public folder...
call php artisan vendor:publish --provider=OpenBoost\\UI\\OpenBoostServiceProvider --tag=open-boost-ui --force

if %ERRORLEVEL% neq 0 (
    echo ERROR: Failed to publish assets
    pause
    exit /b 1
)

echo.
echo ✓ Assets published successfully!
echo.
echo ========================================
echo Step 2: Update Your Layout File
echo ========================================
echo.
echo Open: resources/views/layouts/app.blade.php
echo.
echo Add these CSS links in the ^<head^>:
echo.
echo   ^<!-- Select2 CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/select2/select2.min.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- Flatpickr CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- Quill CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/quill/quill.snow.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- SimpleMDE CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- Trix CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/trix/trix.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- ApexCharts CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- DataTables CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/datatables.net/jquery.dataTables.min.css') }}" rel="stylesheet"^>
echo.
echo   ^<!-- Choices.js CSS --^>
echo   ^<link href="{{ asset('vendor/open-boost/assets/choices.js/choices.min.css') }}" rel="stylesheet"^>
echo.
echo.
echo Add these JavaScript includes before ^</body^>:
echo.
echo   ^<!-- jQuery (MUST be first) --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/jquery/jquery.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Select2 --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/select2/select2.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Flatpickr --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/flatpickr/flatpickr.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Quill --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/quill/quill.min.js') }}"^>^</script^>
echo.
echo   ^<!-- SimpleMDE --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/simplemde/simplemde.min.js') }}"^>^</script^>
echo.
echo   ^<!-- ApexCharts --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/apexcharts/apexcharts.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Chart.js --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/chart.js/chart.min.js') }}"^>^</script^>
echo.
echo   ^<!-- DataTables --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/datatables.net/jquery.dataTables.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Choices.js --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/choices.js/choices.min.js') }}"^>^</script^>
echo.
echo   ^<!-- Trix --^>
echo   ^<script src="{{ asset('vendor/open-boost/assets/trix/trix.js') }}"^>^</script^>
echo.
echo   ^<!-- OpenBoost Auto-Initialization (do NOT remove) --^>
echo   ^<script src="{{ asset('vendor/open-boost/js/open-boost-init.js') }}"^>^</script^>
echo.
echo.
echo ========================================
echo Step 3: Test It Out!
echo ========================================
echo.
echo Create a test page with this component:
echo.
echo   ^<x-openBoost-select name="test" lib="select2" theme="bootstrap"^>
echo       ^<option value=""^>Select something...^</option^>
echo       ^<option value="1"^>Option 1^</option^>
echo       ^<option value="2"^>Option 2^</option^>
echo   ^</x-openBoost-select^>
echo.
echo.
echo ========================================
echo Step 4: Verify Everything Works
echo ========================================
echo.
echo 1. Open your test page in browser
echo 2. Press F12 to open DevTools
echo 3. Go to Console tab
echo 4. Copy and paste:
echo.
echo    OpenBoost.debug()
echo.
echo 5. Press Enter
echo 6. You should see all libraries marked with ✅
echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Click on your Select2 select to see it in action.
echo All components should be fully functional.
echo.
pause
