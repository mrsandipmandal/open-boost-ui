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

                // Detect multiple mode from either the HTML attribute or the name attribute (ending with [])
                const hasMultipleAttr = select.hasAttribute('multiple');
                const hasMultipleName = select.name && select.name.endsWith('[]');
                const isMultiple = hasMultipleAttr || hasMultipleName;
                
                // CRITICAL: Ensure the multiple attribute is set BEFORE Select2 initialization
                if (isMultiple) {
                    select.setAttribute('multiple', 'multiple');
                    select.multiple = true;
                }
                
                // Destroy existing Select2 instance if it exists
                if ($(select).hasClass('select2-hidden-accessible')) {
                    try {
                        $(select).select2('destroy');
                    } catch (e) {
                        // Ignore destroy errors
                    }
                }
                
                const options = {
                    minimumResultsForSearch: search ? 0 : Infinity,
                    width: '100%',
                    allowClear: true,
                    closeOnSelect: !isMultiple // Keep dropdown open for multiple select
                };
                
                if (selectTheme) {
                    options.theme = selectTheme;
                }
                
                try {
                    // Initialize Select2 with proper configuration
                    $(select).select2(options);
                    
                    // Verify multiple mode is active
                    const select2Instance = $(select).data('select2');
                    if (select2Instance && isMultiple) {
                        // Force the container to show multiple mode
                        if (select2Instance.$container) {
                            select2Instance.$container.addClass('select2-container--multiple');
                        }
                    }
                    
                    // Ensure options are displayed
                    $(select).on('select2:opening', function() {
                        const dropdown = $(this).data('select2').$dropdown;
                        if (dropdown) {
                            const searchField = dropdown.find('.select2-search__field');
                            if (searchField.length) {
                                searchField.attr('aria-label', 'Search');
                            }
                        }
                    });
                    
                    // Handle change event to show selected values
                    $(select).on('change', function() {
                        console.log('Select2 change event - selected values:', $(this).val());
                    });
                    
                    console.log('Select2 initialized on:', select.id, 'name:', select.name, 'options:', select.querySelectorAll('option').length, 'multiple:', isMultiple, 'classes:', select.className);
                } catch (e) {
                    console.error('Select2 initialization error:', e);
                    console.error('Select element:', select);
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

    initAccordions() {
        document.querySelectorAll('[data-openboost-accordion]').forEach(accordion => {
            const allowMultiple = accordion.dataset.openboostAccordionMultiple === '1';
            const items = accordion.querySelectorAll('[data-openboost-accordion-item]');

            items.forEach(item => {
                const trigger = item.querySelector('[data-openboost-accordion-trigger]');
                const content = item.querySelector('[data-openboost-accordion-content]');
                const icon = trigger?.querySelector('.openBoost-accordion-icon');

                if (!trigger || !content) return;

                trigger.addEventListener('click', () => {
                    const isActive = item.dataset.openboostAccordionItemActive === '1';

                    if (!allowMultiple) {
                        items.forEach(sibling => {
                            if (sibling !== item) {
                                sibling.querySelector('[data-openboost-accordion-content]').classList.add('hidden');
                                sibling.dataset.openboostAccordionItemActive = '0';
                                const siblingIcon = sibling.querySelector('.openBoost-accordion-icon');
                                if (siblingIcon) siblingIcon.style.transform = 'rotate(0deg)';
                            }
                        });
                    }

                    if (isActive) {
                        content.classList.add('hidden');
                        item.dataset.openboostAccordionItemActive = '0';
                        trigger.setAttribute('aria-expanded', 'false');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    } else {
                        content.classList.remove('hidden');
                        item.dataset.openboostAccordionItemActive = '1';
                        trigger.setAttribute('aria-expanded', 'true');
                        if (icon) icon.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
    },

    initCarousels() {
        document.querySelectorAll('[data-openboost-carousel]').forEach(carousel => {
            const slides = carousel.querySelectorAll('[data-openboost-carousel-slide]');
            const autoPlay = carousel.dataset.openboostCarouselAutoplay === '1';
            const interval = parseInt(carousel.dataset.openboostCarouselInterval) || 5000;
            const showIndicators = carousel.dataset.openboostCarouselIndicators === '1';
            let currentIndex = 0;
            let autoPlayInterval = null;

            const showSlide = (index) => {
                slides.forEach((slide, i) => {
                    if (i === index) {
                        slide.classList.remove('hidden');
                    } else {
                        slide.classList.add('hidden');
                    }
                });

                if (showIndicators) {
                    carousel.querySelectorAll('[data-openboost-carousel-indicator]').forEach((indicator, i) => {
                        indicator.classList.toggle('bg-gray-800', i === index);
                        indicator.classList.toggle('bg-gray-400', i !== index);
                    });
                }
            };

            const createIndicators = () => {
                const indicatorsContainer = carousel.querySelector('[data-openboost-carousel-indicators]');
                if (!indicatorsContainer) return;

                slides.forEach((_, index) => {
                    const indicator = document.createElement('button');
                    indicator.type = 'button';
                    indicator.setAttribute('data-openboost-carousel-indicator', 'true');
                    indicator.setAttribute('aria-label', `Go to slide ${index + 1}`);
                    indicator.className = `w-3 h-3 rounded-full transition-colors ${index === 0 ? 'bg-gray-800' : 'bg-gray-400'}`;
                    indicator.addEventListener('click', () => {
                        currentIndex = index;
                        showSlide(currentIndex);
                        clearInterval(autoPlayInterval);
                        if (autoPlay) startAutoPlay();
                    });
                    indicatorsContainer.appendChild(indicator);
                });
            };

            const nextSlide = () => {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            };

            const prevSlide = () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                showSlide(currentIndex);
            };

            const startAutoPlay = () => {
                if (autoPlay) {
                    autoPlayInterval = setInterval(nextSlide, interval);
                }
            };

            carousel.querySelector('[data-openboost-carousel-next]')?.addEventListener('click', () => {
                nextSlide();
                clearInterval(autoPlayInterval);
                if (autoPlay) startAutoPlay();
            });

            carousel.querySelector('[data-openboost-carousel-prev]')?.addEventListener('click', () => {
                prevSlide();
                clearInterval(autoPlayInterval);
                if (autoPlay) startAutoPlay();
            });

            if (slides.length > 0) {
                if (showIndicators) createIndicators();
                showSlide(0);
                startAutoPlay();
            }
        });
    },

    initTabs() {
        document.querySelectorAll('[data-openboost-tabs]').forEach(tabsContainer => {
            const triggers = tabsContainer.querySelectorAll('[data-openboost-tab-trigger]');
            const panels = tabsContainer.querySelectorAll('[data-openboost-tab-panel]');

            triggers.forEach((trigger, index) => {
                trigger.addEventListener('click', () => {
                    triggers.forEach(t => {
                        t.setAttribute('aria-selected', 'false');
                        t.dataset.openboostTabActive = '0';
                        t.classList.remove('border-blue-500', 'text-blue-600');
                        t.classList.add('border-transparent', 'text-gray-600');
                    });

                    panels.forEach(panel => {
                        panel.classList.add('hidden');
                        panel.dataset.openboostTabActive = '0';
                    });

                    trigger.setAttribute('aria-selected', 'true');
                    trigger.dataset.openboostTabActive = '1';
                    trigger.classList.add('border-blue-500', 'text-blue-600');
                    trigger.classList.remove('border-transparent', 'text-gray-600');
                    
                    if (panels[index]) {
                        panels[index].classList.remove('hidden');
                        panels[index].dataset.openboostTabActive = '1';
                    }
                });
            });
        });
    },

    initRadioGroups() {
        document.querySelectorAll('[data-openboost-radiogroup]').forEach(group => {
            const radios = group.querySelectorAll('[data-openboost-radio-input]');
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    radios.forEach(r => {
                        r.parentElement.dataset.openboostRadioChecked = r.checked ? '1' : '0';
                    });
                });
            });
        });
    },

    initToggles() {
        document.querySelectorAll('[data-openboost-toggle]').forEach(toggle => {
            const input = toggle.querySelector('[data-openboost-toggle-input]');
            const track = toggle.querySelector('[data-openboost-toggle-track]');
            const thumb = toggle.querySelector('[data-openboost-toggle-thumb]');

            if (!input) return;

            const updateToggle = () => {
                if (input.checked) {
                    track.classList.add('bg-blue-500');
                    track.classList.remove('bg-gray-300');
                    thumb.style.transform = 'translateX(1.5rem)';
                } else {
                    track.classList.remove('bg-blue-500');
                    track.classList.add('bg-gray-300');
                    thumb.style.transform = 'translateX(0)';
                }
            };

            input.addEventListener('change', updateToggle);
            updateToggle();
        });
    },

    initTooltips() {
        document.querySelectorAll('[data-openboost-tooltip]').forEach(tooltip => {
            const content = tooltip.querySelector('[data-openboost-tooltip-content]');
            if (!content) return;

            tooltip.addEventListener('mouseenter', () => {
                content.classList.remove('hidden');
            });

            tooltip.addEventListener('mouseleave', () => {
                content.classList.add('hidden');
            });

            tooltip.addEventListener('focus', () => {
                content.classList.remove('hidden');
            }, true);

            tooltip.addEventListener('blur', () => {
                content.classList.add('hidden');
            }, true);
        });
    },

    initNotifications() {
        document.querySelectorAll('[data-openboost-notification]').forEach(notification => {
            const dismissButton = notification.querySelector('[data-openboost-notification-close]');
            const autoClose = notification.dataset.openboostNotificationAutoclose === '1';
            const closeDelay = parseInt(notification.dataset.openboostNotificationDelay) || 5000;

            const removeNotification = () => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            };

            if (dismissButton) {
                dismissButton.addEventListener('click', removeNotification);
            }

            if (autoClose) {
                setTimeout(removeNotification, closeDelay);
            }
        });
    },

    initDatatables() {
        document.querySelectorAll('[data-openboost-datatable]').forEach(table => {
            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr');
            rows.forEach(row => {
                row.classList.add('hover:bg-gray-100');
            });
        });
    },

    initLists() {
        document.querySelectorAll('[data-openboost-list]').forEach(list => {
            const items = list.querySelectorAll('[data-openboost-list-item]');
            const perPage = parseInt(list.dataset.openboostListPerpage) || 10;
            let currentPage = 1;

            const totalPages = Math.ceil(items.length / perPage);
            const prevBtn = list.querySelector('[data-openboost-list-prev]');
            const nextBtn = list.querySelector('[data-openboost-list-next]');
            const pagesContainer = list.querySelector('[data-openboost-list-pages]');

            const renderPage = (page) => {
                const start = (page - 1) * perPage;
                const end = start + perPage;

                items.forEach((item, index) => {
                    item.style.display = index >= start && index < end ? 'block' : 'none';
                });

                prevBtn.disabled = page === 1;
                nextBtn.disabled = page === totalPages;

                if (pagesContainer) {
                    pagesContainer.innerHTML = '';
                    for (let i = 1; i <= totalPages; i++) {
                        const pageBtn = document.createElement('button');
                        pageBtn.type = 'button';
                        pageBtn.textContent = i;
                        pageBtn.className = `px-3 py-1 border rounded transition-colors ${
                            i === page ? 'bg-blue-500 text-white' : 'border-gray-300 hover:bg-gray-100'
                        }`;
                        pageBtn.addEventListener('click', () => {
                            currentPage = i;
                            renderPage(currentPage);
                        });
                        pagesContainer.appendChild(pageBtn);
                    }
                }
            };

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage(currentPage);
                    }
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage(currentPage);
                    }
                });
            }

            if (items.length > 0) {
                renderPage(1);
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
        this.initAccordions();
        this.initCarousels();
        this.initTabs();
        this.initRadioGroups();
        this.initToggles();
        this.initTooltips();
        this.initNotifications();
        this.initDatatables();
        this.initLists();
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
        console.log('Accordions:', document.querySelectorAll('[data-openboost-accordion]').length);
        console.log('Carousels:', document.querySelectorAll('[data-openboost-carousel]').length);
        console.log('Tabs:', document.querySelectorAll('[data-openboost-tabs]').length);
        console.log('Radio Groups:', document.querySelectorAll('[data-openboost-radiogroup]').length);
        console.log('Toggles:', document.querySelectorAll('[data-openboost-toggle]').length);
        console.log('Tooltips:', document.querySelectorAll('[data-openboost-tooltip]').length);
        console.log('Notifications:', document.querySelectorAll('[data-openboost-notification]').length);
        console.log('Datatables:', document.querySelectorAll('[data-openboost-datatable]').length);
        console.log('Lists:', document.querySelectorAll('[data-openboost-list]').length);
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

// OpenBoost.debug();
// console.log('open-boost-init tag?', !!document.querySelector('script[src*="open-boost-init.js"]'));
// console.log('select2 script tag?', !!document.querySelector('script[src*="select2.min.js"]'));
// console.log('select2 css tag?', !!document.querySelector('link[href*="select2.min.css"]'));
// console.log('flatpickr script tag?', !!document.querySelector('script[src*="flatpickr.min.js"]'));
// console.log('flatpickr css tag?', !!document.querySelector('link[href*="flatpickr.min.css"]'));
// console.log('select element', document.querySelector('[data-openboost-select]'));
// console.log('datepicker element', document.querySelector('[data-openboost-datepicker]'));

// Fallback helper used by other scripts that expect select2Focus to exist
if (typeof window.select2Focus === 'undefined') {
    window.select2Focus = function (el) {
        try {
            if (window.jQuery && jQuery(el).data('select2')) {
                jQuery(el).select2('open');
            }
        } catch (e) {
            // noop
        }
    };
}
