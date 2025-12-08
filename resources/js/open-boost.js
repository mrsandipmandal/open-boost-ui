// open-boost.js
// Central JS init file for open-boost-ui

import $ from 'jquery';
import 'select2';
import Choices from 'choices.js';
import flatpickr from 'flatpickr';
import Chart from 'chart.js/auto';
import ApexCharts from 'apexcharts';
import Quill from 'quill';
import SimpleMDE from 'simplemde';
import 'trix';

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
            // optional: data-flash-select-theme="bootstrap-5" to use Select2 bootstrap theme
            const selectTheme = select.dataset.flashSelectTheme || select.dataset.theme || '';

            if (lib === 'select2') {
                const options = {
                    minimumResultsForSearch: search ? 0 : Infinity
                };
                if (selectTheme) {
                    options.theme = selectTheme;
                }
                $(select).select2(options);
            } else if (lib === 'choices') {
                new Choices(select, {
                    searchEnabled: search
                });
            }
        });
    },

    initDatepickers() {
        document.querySelectorAll('[data-flash-datepicker]').forEach(input => {
            const lib = input.dataset.flashDatepickerLib || 'flatpickr';
            const mode = input.dataset.flashDatepickerMode || 'single';
            const enableTime = input.dataset.flashDatepickerTime === '1';

            if (lib === 'flatpickr') {
                flatpickr(input, {
                    mode,
                    enableTime
                });
            }
        });
    },

    initCharts() {
        document.querySelectorAll('[data-flash-chart]').forEach(el => {
            const engine = el.dataset.flashChartEngine || 'chartjs';
            const type = el.dataset.flashChartType || 'line';
                // Enhanced modals: support transitions, escape-to-close, focus-trap, return focus
                document.querySelectorAll('[data-flash-modal]').forEach(modal => {
                    const id = modal.id;

                    // Options via data- attributes
                    const allowEscape = modal.dataset.flashModalEsc !== '0'; // default true
                    const trapFocus = modal.dataset.flashModalTrap !== '0'; // default true
                    const returnFocus = modal.dataset.flashModalReturn !== '0'; // default true
                    const useFade = modal.dataset.flashModalFade !== '0'; // default true

                    let lastActive = null;

                    const focusableSelector = 'a[href], area[href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex], [contenteditable]';

                    function getFocusableElements(root) {
                        return Array.from(root.querySelectorAll(focusableSelector)).filter(el => el.tabIndex !== -1);
                    }

                    function openModal(trigger) {
                        lastActive = trigger || document.activeElement;

                        // show
                        modal.classList.remove('hidden');
                        modal.setAttribute('aria-hidden', 'false');

                        if (useFade) {
                            modal.style.transition = 'opacity 200ms ease';
                            modal.style.opacity = 0;
                            // force reflow
                            void modal.offsetWidth;
                            modal.style.opacity = 1;
                        }

                        // focus first focusable element or modal itself
                        const focusables = getFocusableElements(modal);
                        if (focusables.length) {
                            focusables[0].focus();
                        } else {
                            modal.tabIndex = -1;
                            modal.focus();
                        }

                        if (trapFocus) {
                            document.addEventListener('keydown', handleTrap);
                        }
                        if (allowEscape) {
                            document.addEventListener('keydown', handleEscape);
                        }
                    }

                    function closeModal() {
                        if (useFade) {
                            modal.style.opacity = 0;
                            setTimeout(() => {
                                modal.classList.add('hidden');
                                modal.style.transition = '';
                                modal.style.opacity = '';
                            }, 200);
                        } else {
                            modal.classList.add('hidden');
                        }
                        modal.setAttribute('aria-hidden', 'true');

                        if (trapFocus) {
                            document.removeEventListener('keydown', handleTrap);
                        }
                        if (allowEscape) {
                            document.removeEventListener('keydown', handleEscape);
                        }

                        if (returnFocus && lastActive && typeof lastActive.focus === 'function') {
                            lastActive.focus();
                        }
                    }

                    function handleEscape(e) {
                        if (e.key === 'Escape' || e.key === 'Esc') {
                            closeModal();
                        }
                    }

                    function handleTrap(e) {
                        if (e.key !== 'Tab') return;
                        const focusables = getFocusableElements(modal);
                        if (!focusables.length) {
                            e.preventDefault();
                            return;
                        }
                        const first = focusables[0];
                        const last = focusables[focusables.length - 1];

                        if (e.shiftKey) {
                            if (document.activeElement === first) {
                                e.preventDefault();
                                last.focus();
                            }
                        } else {
                            if (document.activeElement === last) {
                                e.preventDefault();
                                first.focus();
                            }
                        }
                    }

                    // open triggers
                    document.querySelectorAll(`[data-flash-modal-open="${id}"]`)
                        .forEach(btn => btn.addEventListener('click', (ev) => {
                            openModal(btn);
                        }));

                    // close buttons inside modal
                    modal.querySelectorAll('[data-flash-modal-close]')
                        .forEach(btn => btn.addEventListener('click', () => {
                            closeModal();
                        }));

                    // click on backdrop (modal root) closes
                    modal.addEventListener('click', e => {
                        if (e.target === modal) {
                            closeModal();
                        }
                    });

                });
            },

            initEditors() {
                document.querySelectorAll('[data-flash-editor]').forEach(wrapper => {
                    const engine = wrapper.dataset.flashEditorEngine || 'quill';
                    const id = wrapper.dataset.flashEditorId;
                    const textarea = wrapper.querySelector('textarea');
                    const target = wrapper.querySelector('[data-flash-editor-target]');

                    if (!textarea || !target) return;

                    if (engine === 'quill') {
                        const quill = new Quill(target, {
                            theme: 'snow'
                        });
                        quill.root.innerHTML = textarea.value;
                        quill.on('text-change', () => {
                            textarea.value = quill.root.innerHTML;
                        });
                    } else if (engine === 'simplemde') {
                        new SimpleMDE({ element: textarea });
                    } else if (engine === 'trix') {
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

        if (typeof window !== 'undefined') {
            window.OpenBoost = OpenBoost;
            document.addEventListener('DOMContentLoaded', () => {
                OpenBoost.initAll();
            });
        }

        export default OpenBoost;
