/**
 * OpenBoost Component Initialization
 * Include this after all library JS files are loaded
 */

const OpenBoost = {
    initDropdowns() {
        document.querySelectorAll('[data-openBoost-dropdown]').forEach(dropdown => {
            const toggle = dropdown.querySelector('[data-openBoost-dropdown-toggle]');
            const menu = dropdown.querySelector('[data-openBoost-dropdown-menu]');
            if (!toggle || !menu) return;

            toggle.addEventListener('click', e => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    },

    initModals() {
        document.querySelectorAll('[data-openBoost-modal]').forEach(modal => {
            const id = modal.id;

            document.querySelectorAll(`[data-openBoost-modal-open="${id}"]`)
                .forEach(btn => btn.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                }));

            modal.querySelectorAll('[data-openBoost-modal-close]')
                .forEach(btn => btn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                }));

            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    },

    initSelects() {
        document.querySelectorAll('[data-openboost-select]').forEach(select => {
            const lib = select.dataset.openboostSelectLib || 'select2';
            const search = select.dataset.openboostSelectSearch === '1';
            const selectTheme = select.dataset.openboostSelectTheme || '';

            if (lib === 'select2') {
                // jQuery and Select2 must be loaded before this
                if (typeof $ === 'undefined') {
                    console.error('Select2: jQuery is not loaded. Include jQuery before open-boost-init.js');
                    return;
                }
                if (!$.fn.select2) {
                    console.error('Select2: Select2 library is not loaded. Include Select2 JS before open-boost-init.js');
                    return;
                }

                const options = {
                    minimumResultsForSearch: search ? 0 : Infinity,
                    width: '100%'
                };
                
                if (selectTheme) {
                    options.theme = selectTheme;
                }
                
                try {
                    $(select).select2(options);
                    console.log('Select2 initialized on:', select.id);
                } catch (e) {
                    console.error('Select2 initialization error:', e);
                }
            } else if (lib === 'choices') {
                // Choices.js must be loaded before this
                if (typeof Choices !== 'undefined') {
                    new Choices(select, {
                        searchEnabled: search
                    });
                } else {
                    console.warn('Choices.js: library not loaded');
                }
            }
        });
    },

    initDatepickers() {
        document.querySelectorAll('[data-openboost-datepicker]').forEach(input => {
            const lib = input.dataset.openboostDatepickerLib || 'flatpickr';
            const mode = input.dataset.openboostDatepickerMode || 'single';
            const enableTime = input.dataset.openboostDatepickerTime === '1';

            if (lib === 'flatpickr') {
                // Flatpickr must be loaded before this
                if (typeof flatpickr !== 'undefined') {
                    flatpickr(input, {
                        mode,
                        enableTime
                    });
                } else {
                    console.warn('Flatpickr: library not loaded');
                }
            }
        });
    },

    initCharts() {
        document.querySelectorAll('[data-openboost-chart]').forEach(el => {
            const engine = el.dataset.openboostChartEngine || 'chartjs';
            const type = el.dataset.openboostChartType || 'line';
            const dataStr = el.dataset.openboostChartData;

            if (!dataStr) return;

            try {
                const chartData = JSON.parse(dataStr);

                if (engine === 'chartjs' && typeof Chart !== 'undefined') {
                    new Chart(el, {
                        type: type,
                        data: chartData
                    });
                } else if (engine === 'apexcharts' && typeof ApexCharts !== 'undefined') {
                    new ApexCharts(el, chartData).render();
                }
            } catch (e) {
                console.error('Chart initialization error:', e);
            }
        });
    },

    initEditors() {
        document.querySelectorAll('[data-openboost-editor]').forEach(wrapper => {
            const engine = wrapper.dataset.openboostEditorEngine || 'quill';
            const id = wrapper.dataset.openboostEditorId;
            const textarea = wrapper.querySelector('textarea');
            const target = wrapper.querySelector('[data-openboost-editor-target]');

            if (!textarea || !target) return;

            if (engine === 'quill' && typeof Quill !== 'undefined') {
                const quill = new Quill(target, {
                    theme: 'snow'
                });
                quill.root.innerHTML = textarea.value;
                quill.on('text-change', () => {
                    textarea.value = quill.root.innerHTML;
                });
            } else if (engine === 'simplemde' && typeof SimpleMDE !== 'undefined') {
                new SimpleMDE({ element: textarea });
            } else if (engine === 'trix' && typeof Trix !== 'undefined') {
                const hiddenInputId = id + '-trix-input';
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.id = hiddenInputId;
                hidden.value = textarea.value;
                textarea.after(hidden);

                const trix = document.createElement('trix-editor');
                trix.setAttribute('input', hiddenInputId);
                target.appendChild(trix);
            }
        });
    },

    initAll() {
        this.initDropdowns();
        this.initModals();
        this.initSelects();
        this.initDatepickers();
        this.initCharts();
        this.initEditors();
    },

    // Debug helper - call OpenBoost.debug() in console to check setup
    debug() {
        console.group('🔍 OpenBoost Debug Info');
        
        console.group('Dependencies');
        console.log('jQuery ($):', typeof $ !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Select2:', typeof $ !== 'undefined' && $.fn.select2 ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Choices:', typeof Choices !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Flatpickr:', typeof flatpickr !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Chart.js:', typeof Chart !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('ApexCharts:', typeof ApexCharts !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Quill:', typeof Quill !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('SimpleMDE:', typeof SimpleMDE !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.log('Trix:', typeof Trix !== 'undefined' ? '✅ Loaded' : '❌ NOT LOADED');
        console.groupEnd();

        console.group('Components Found');
        console.log('Selects:', document.querySelectorAll('[data-openboost-select]').length);
        console.log('Datepickers:', document.querySelectorAll('[data-openboost-datepicker]').length);
        console.log('Charts:', document.querySelectorAll('[data-openboost-chart]').length);
        console.log('Editors:', document.querySelectorAll('[data-openboost-editor]').length);
        console.log('Dropdowns:', document.querySelectorAll('[data-openboost-dropdown]').length);
        console.log('Modals:', document.querySelectorAll('[data-openboost-modal]').length);
        console.groupEnd();

        console.groupEnd();
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('🚀 OpenBoost: Initializing components...');
        OpenBoost.initAll();
    });
} else {
    console.log('🚀 OpenBoost: Initializing components...');
    OpenBoost.initAll();
}

// Export for manual initialization
if (typeof window !== 'undefined') {
    window.OpenBoost = OpenBoost;
}

OpenBoost.debug();
console.log('open-boost-init tag?', !!document.querySelector('script[src*="open-boost-init.js"]'));
console.log('select2 script tag?', !!document.querySelector('script[src*="select2.min.js"]'));
console.log('select2 css tag?', !!document.querySelector('link[href*="select2.min.css"]'));
console.log('flatpickr script tag?', !!document.querySelector('script[src*="flatpickr.min.js"]'));
console.log('flatpickr css tag?', !!document.querySelector('link[href*="flatpickr.min.css"]'));
console.log('select element', document.querySelector('[data-openboost-select]'));
console.log('datepicker element', document.querySelector('[data-openboost-datepicker]'));
