/**
 * PATHJOLPONA - Modern Dark Mode Controller
 * Handles persistent dark mode across pages, zero-flash loading,
 * system preference sync, and tactile animated toggle buttons.
 */
(function (window, document) {
    'use strict';

    var STORAGE_KEY = 'app_theme';

    /**
     * Get preferred theme: user preference in localStorage takes precedence,
     * falling back to OS system preference.
     */
    function getPreferredTheme() {
        var storedTheme = localStorage.getItem(STORAGE_KEY);
        if (storedTheme === 'dark' || storedTheme === 'light') {
            return storedTheme;
        }
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    /**
     * Apply theme to the document and update all toggle buttons on page
     */
    function applyTheme(theme) {
        var isDark = theme === 'dark';
        var root = document.documentElement;

        if (isDark) {
            root.classList.add('dark-theme');
            root.setAttribute('data-theme', 'dark');
        } else {
            root.classList.remove('dark-theme');
            root.setAttribute('data-theme', 'light');
        }

        // Update all toggle buttons in DOM
        var toggleBtns = document.querySelectorAll('.theme-toggle-btn');
        toggleBtns.forEach(function (btn) {
            btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            var label = isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode';
            btn.setAttribute('aria-label', label);
            btn.setAttribute('title', label);

            var textLabel = btn.querySelector('.theme-toggle-label');
            if (textLabel) {
                textLabel.textContent = isDark ? 'Light Mode' : 'Dark Mode';
            }
        });

        // Dispatch custom event for widgets/charts
        try {
            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: theme } }));
        } catch (e) {
            // older browsers fallback
        }
    }

    /**
     * Toggle theme function
     */
    window.toggleAppTheme = function () {
        var currentTheme = document.documentElement.getAttribute('data-theme') || 
            (document.documentElement.classList.contains('dark-theme') ? 'dark' : 'light');
        var newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        localStorage.setItem(STORAGE_KEY, newTheme);
        applyTheme(newTheme);
        return newTheme;
    };

    // Initialize as soon as DOM is ready
    function initThemeButtons() {
        var currentTheme = getPreferredTheme();
        applyTheme(currentTheme);

        // Click handler for toggle buttons
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.theme-toggle-btn, [data-action="toggle-theme"]');
            if (btn) {
                e.preventDefault();
                window.toggleAppTheme();
            }
        });
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeButtons);
    } else {
        initThemeButtons();
    }

    // Listen to OS system color scheme changes if user hasn't explicitly set preference
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            if (!localStorage.getItem(STORAGE_KEY)) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
})(window, document);
