import './bootstrap';
import "flyonui/flyonui"
import './main.js';
import './echo';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import './flatpickr.js';


function initNotyf() {
    window.notyf = new Notyf({
        duration: 2500,
        position: { x: "right", y: "top" },
        dismissible: true,
    });

    window.flatpickr = flatpickr
}

// inisialisasi awal
initNotyf();

document.addEventListener("livewire:init", () => {
    Livewire.on("notify", ({ type, message }) => {
        if (!window.notyf) initNotyf();
        if (type === "success") {
            window.notyf.success(message);
        } else {
            window.notyf.error(message);
        }
    });
});

const reinitFlyonUI = () => {
    try {
        if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
            window.HSStaticMethods.autoInit('all');
            if (window.HSSelect) {
                window.HSSelect.getInstance('#select');
            }
        }
    } catch (e) {
        console.warn("FlyonUI reinit gagal:", e);
    }
};


// --- hook untuk FlyonUI setelah navigasi/DOM update ---
document.addEventListener('livewire:load', () => {
    reinitFlyonUI();

    if (window.Livewire && typeof window.Livewire.hook === 'function') {
        window.Livewire.hook('message.processed', () => {
            reinitFlyonUI();
        });
    }
});

document.addEventListener('livewire:navigated', () => {
    reinitFlyonUI();
    initNotyf();
});


// window.Echo.channel('debug-channel')
//     .listen('.debug.event', (e) => {

//         alert("okeee")
//         console.log("📡 Event diterima:", e);
//     });
