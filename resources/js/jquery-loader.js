/**
 * jQuery Loader
 * 
 * IMPORTANT: This script MUST be loaded BEFORE any jQuery-dependent plugins!
 * 
 * This script:
 * 1. Waits for jQuery to be available globally
 * 2. Exposes jQuery as window.$ and window.jQuery
 * 3. Provides a way for dependent scripts to register and wait for jQuery
 * 4. Initializes dependent scripts once jQuery is ready
 */

(function(window) {
    'use strict';

    // Store references to dependent script loaders
    const pendingScripts = [];
    let jQueryReady = false;

    // jQuery readiness checker
    const checkJQuery = function() {
        if (typeof jQuery !== 'undefined' && jQuery) {
            if (!jQueryReady) {
                jQueryReady = true;
                // Expose globally
                window.$ = jQuery;
                window.jQuery = jQuery;
                console.log('✅ jQuery is ready and exposed as $ and jQuery');
                
                // Initialize any pending scripts that were waiting for jQuery
                initializePendingScripts();
            }
            return true;
        }
        return false;
    };

    // Initialize scripts that were waiting for jQuery
    const initializePendingScripts = function() {
        if (pendingScripts.length > 0) {
            console.log(`🚀 Initializing ${pendingScripts.length} dependent script(s)...`);
            pendingScripts.forEach(callback => {
                try {
                    callback();
                } catch (e) {
                    console.error('Error initializing dependent script:', e);
                }
            });
            pendingScripts.length = 0; // Clear the array
        }
    };

    // Expose jQuery loader API to window
    window.jQueryLoader = {
        /**
         * Check if jQuery is ready
         */
        isReady: function() {
            return checkJQuery();
        },

        /**
         * Register a callback to run once jQuery is available
         */
        onReady: function(callback) {
            if (checkJQuery()) {
                // jQuery already ready, run immediately
                try {
                    callback();
                } catch (e) {
                    console.error('Error in jQuery ready callback:', e);
                }
            } else {
                // jQuery not ready, queue the callback
                pendingScripts.push(callback);
            }
        },

        /**
         * Wait for jQuery and expose it globally
         */
        ensure: function() {
            return checkJQuery();
        },

        /**
         * Get jQuery with timeout
         */
        getWithTimeout: function(timeout = 5000) {
            return new Promise((resolve, reject) => {
                const startTime = Date.now();
                const checkInterval = setInterval(() => {
                    if (checkJQuery()) {
                        clearInterval(checkInterval);
                        resolve(window.jQuery);
                    } else if (Date.now() - startTime > timeout) {
                        clearInterval(checkInterval);
                        reject(new Error('jQuery did not load within ' + timeout + 'ms'));
                    }
                }, 100);
            });
        }
    };

    // Check immediately in case jQuery is already loaded
    checkJQuery();

    // Also check periodically for jQuery (in case it loads async)
    let checkCount = 0;
    const maxChecks = 100; // Check for up to 10 seconds (100 * 100ms)
    const intervalId = setInterval(function() {
        checkCount++;
        if (checkJQuery() || checkCount >= maxChecks) {
            clearInterval(intervalId);
            if (checkCount >= maxChecks && !jQueryReady) {
                console.error('❌ jQuery did not load within 10 seconds');
            }
        }
    }, 100);

    // Also try MutationObserver to detect when jQuery script loads
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function() {
            if (checkJQuery()) {
                observer.disconnect();
            }
        });

        observer.observe(document.documentElement, {
            attributes: true,
            childList: true,
            subtree: true
        });
    }

})(window);
