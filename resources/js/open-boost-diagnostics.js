/**
 * OpenBoost Diagnostics
 * 
 * Include this script AFTER all other scripts to diagnose loading issues
 * <script src="/path/to/open-boost-diagnostics.js"></script>
 */

(function(window) {
    'use strict';

    const Diagnostics = {
        // Run all diagnostic checks
        runAll: function() {
            console.clear();
            console.group('🔧 OpenBoost Diagnostics Report');
            this.checkJQuery();
            this.checkLibraries();
            this.checkOpenBoost();
            this.checkDOM();
            console.groupEnd();
        },

        // Check jQuery availability
        checkJQuery: function() {
            console.group('jQuery Status');
            const jQueryTypes = {
                'window.jQuery': typeof window.jQuery,
                'window.$': typeof window.$,
                'global jQuery': typeof jQuery !== 'undefined' ? typeof jQuery : 'undefined'
            };

            let jQueryOk = false;
            for (let key in jQueryTypes) {
                const isFunction = jQueryTypes[key] === 'function';
                const status = isFunction ? '✅' : '❌';
                console.log(`${status} ${key}: ${jQueryTypes[key]}`);
                if (isFunction) jQueryOk = true;
            }

            if (jQueryOk) {
                const version = jQuery.fn.jquery || 'unknown';
                console.log(`✅ jQuery Version: ${version}`);
            } else {
                console.error('❌ jQuery is NOT available!');
                console.error('Make sure jQuery is loaded BEFORE other plugins');
            }

            console.groupEnd();
            return jQueryOk;
        },

        // Check jQuery plugins
        checkLibraries: function() {
            console.group('jQuery Plugins & Libraries');

            const checks = [
                { name: 'Select2', test: () => typeof $ !== 'undefined' && $.fn.select2 },
                { name: 'DataTables', test: () => typeof $ !== 'undefined' && $.fn.dataTable },
                { name: 'jsTree', test: () => typeof $ !== 'undefined' && $.fn.jstree },
                { name: 'Choices.js', test: () => typeof Choices !== 'undefined' },
                { name: 'Flatpickr', test: () => typeof flatpickr !== 'undefined' },
                { name: 'Chart.js', test: () => typeof Chart !== 'undefined' },
                { name: 'ApexCharts', test: () => typeof ApexCharts !== 'undefined' },
                { name: 'Quill', test: () => typeof Quill !== 'undefined' },
                { name: 'SimpleMDE', test: () => typeof SimpleMDE !== 'undefined' },
                { name: 'Trix', test: () => typeof Trix !== 'undefined' }
            ];

            checks.forEach(lib => {
                const available = lib.test();
                const status = available ? '✅' : '⚠️';
                console.log(`${status} ${lib.name}: ${available ? 'Loaded' : 'NOT loaded'}`);
            });

            console.groupEnd();
        },

        // Check OpenBoost
        checkOpenBoost: function() {
            console.group('OpenBoost Status');

            if (typeof window.OpenBoost === 'undefined') {
                console.error('❌ OpenBoost is NOT loaded!');
                console.error('Make sure open-boost-init.js is included after all other scripts');
                console.groupEnd();
                return false;
            }

            console.log('✅ OpenBoost is loaded');

            // Try to get debug info
            if (typeof window.OpenBoost.debug === 'function') {
                console.log('Running OpenBoost.debug()...');
                window.OpenBoost.debug();
            }

            console.groupEnd();
            return true;
        },

        // Check DOM elements
        checkDOM: function() {
            console.group('DOM Elements Found');

            const elements = [
                { selector: '[data-openboost-select]', name: 'Selects' },
                { selector: '[data-openboost-datepicker]', name: 'Datepickers' },
                { selector: '[data-openboost-chart]', name: 'Charts' },
                { selector: '[data-openboost-editor]', name: 'Editors' },
                { selector: '[data-openboost-dropdown]', name: 'Dropdowns' },
                { selector: '[data-openboost-modal]', name: 'Modals' },
                { selector: '[data-openboost-toggle]', name: 'Toggles' },
                { selector: '[data-openboost-accordion]', name: 'Accordions' },
                { selector: '[data-openboost-datatable]', name: 'DataTables' }
            ];

            elements.forEach(elem => {
                const count = document.querySelectorAll(elem.selector).length;
                const status = count > 0 ? '✅' : '⚠️';
                console.log(`${status} ${elem.name}: ${count} found`);
            });

            console.groupEnd();
        },

        // Attempt to fix jQuery
        fixJQuery: function() {
            console.log('Attempting to expose jQuery...');
            if (typeof window.jQueryLoader !== 'undefined' && typeof window.jQueryLoader.ensure === 'function') {
                const result = window.jQueryLoader.ensure();
                console.log(result ? '✅ jQuery exposed' : '❌ jQuery not available');
                return result;
            } else if (typeof window.ensureJQuery === 'function') {
                const result = window.ensureJQuery();
                console.log(result ? '✅ jQuery exposed' : '❌ jQuery not available');
                return result;
            } else {
                console.error('No jQuery exposure function available');
                return false;
            }
        }
    };

    // Expose diagnostics to window
    window.OpenBoostDiagnostics = Diagnostics;

    // Auto-run on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                console.log('🔍 Auto-running OpenBoost Diagnostics...');
                Diagnostics.runAll();
            }, 100);
        });
    } else {
        setTimeout(() => {
            console.log('🔍 Auto-running OpenBoost Diagnostics...');
            Diagnostics.runAll();
        }, 100);
    }

})(window);
