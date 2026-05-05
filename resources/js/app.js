import './bootstrap';

import Alpine from 'alpinejs';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Make Chart.js available globally
window.Chart = Chart;

// Alpine.js setup
window.Alpine = Alpine;

// Dark mode component
Alpine.data('darkMode', () => ({
    dark: localStorage.getItem('darkMode') === 'true' ||
          (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    init() {
        this.applyTheme();
    },

    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('darkMode', this.dark);
        this.applyTheme();
    },

    applyTheme() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}));

// Toast notification component
Alpine.data('toast', () => ({
    show: true,

    init() {
        setTimeout(() => {
            this.show = false;
        }, 5000);
    }
}));

// Form submit loading state component
Alpine.data('formSubmit', () => ({
    submitting: false,

    submit(e) {
        if (this.submitting) {
            e.preventDefault();
            return;
        }
        this.submitting = true;
    }
}));

Alpine.start();
