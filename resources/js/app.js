import './bootstrap';
import "flyonui/flyonui"
import './main.js';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

const notyf = new Notyf({
    duration: 5000,
    // ripple: true,
    dismissible: true,
    position: { x: 'right', y: 'bottom' },
});

window.notyf = notyf;


// Re-initialize FlyonUI components after Livewire navigation or updates
// so dynamic content (modals, dropdowns, tabs, etc.) works without full reloads.
const reinitFlyonUI = () => {
    try {
        if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
            window.HSStaticMethods.autoInit('all');
            window.HSSelect.getInstance('#select');
        }
    } catch (e) {
        // Silently ignore to avoid breaking UX if HSStaticMethods is unavailable
    }
};

// On initial Livewire load
document.addEventListener('livewire:load', () => {
    reinitFlyonUI();

    // When any Livewire component finishes a DOM update
    if (window.Livewire && typeof window.Livewire.hook === 'function') {
        window.Livewire.hook('message.processed', () => {
            reinitFlyonUI();
        });
    }
});

// When navigating with wire:navigate (no full page reload)
document.addEventListener('livewire:navigated', () => {
    reinitFlyonUI();
});
