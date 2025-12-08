/**
 * OpenBoost Component Initialization
 * Include this after all library JS files are loaded
 */

const OpenBoost = {
    initDropdowns() {
        document.querySelectorAll('[data-flash-dropdown]').forEach(dropdown => {
            const toggle = dropdown.querySelector('[data-flash-dropdown-toggle]');
            const menu = dropdown.querySelector('[data-flash-dropdown-menu]');
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
        document.querySelectorAll('[data-flash-modal]').forEach(modal => {
            const id = modal.id;

            document.querySelectorAll(`[data-flash-modal-open="${id}"]`)
                .forEach(btn => btn.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                }));

            modal.querySelectorAll('[data-flash-modal-close]')
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
        document.querySelectorAll('[data-flash-select]').forEach(select => {
            const lib = select.dataset.flashSelectLib || 'select2';
            const search = select.dataset.flashSelectSearch === '1';
            const selectTheme = select.dataset.flashSelectTheme || select.dataset.theme || '';

            if (lib === 'select2') {
                // jQuery and Select2 must be loaded before this
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    const options = {
                        minimumResultsForSearch: search ? 0 : Infinity
                    };
                    if (selectTheme) {
                        options.theme = selectTheme;
                    }
                    $(select).select2(options);
                } else {
                    console.warn('Select2: jQuery or Select2 library not loaded');
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
        document.querySelectorAll('[data-flash-datepicker]').forEach(input => {
            const lib = input.dataset.flashDatepickerLib || 'flatpickr';
            const mode = input.dataset.flashDatepickerMode || 'single';
            const enableTime = input.dataset.flashDatepickerTime === '1';

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
        document.querySelectorAll('[data-flash-chart]').forEach(el => {
            const engine = el.dataset.flashChartEngine || 'chartjs';
            const type = el.dataset.flashChartType || 'line';
            const dataStr = el.dataset.flashChartData;

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
        document.querySelectorAll('[data-flash-editor]').forEach(wrapper => {
            const engine = wrapper.dataset.flashEditorEngine || 'quill';
            const id = wrapper.dataset.flashEditorId;
            const textarea = wrapper.querySelector('textarea');
            const target = wrapper.querySelector('[data-flash-editor-target]');

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
    }
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        OpenBoost.initAll();
    });
} else {
    OpenBoost.initAll();
}

// Export for manual initialization
if (typeof window !== 'undefined') {
    window.OpenBoost = OpenBoost;
}
