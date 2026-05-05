import './bootstrap';

import Alpine from 'alpinejs';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Make Chart.js available globally
window.Chart = Chart;

// Alpine.js setup
window.Alpine = Alpine;

// Dark mode store
Alpine.store('darkMode', {
    on: localStorage.getItem('darkMode') === 'true' ||
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    toggle() {
        this.on = !this.on;
        localStorage.setItem('darkMode', this.on);
        this.applyTheme();
    },

    applyTheme() {
        if (this.on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

// Initialize theme
Alpine.store('darkMode').applyTheme();

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
