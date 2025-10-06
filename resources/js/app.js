import "./bootstrap";
import "flyonui/flyonui";
import "./main.js";
import "./echo";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import { InitFlatFickr } from "./flatpickr.js";

function initNotyf() {
    window.notyf = new Notyf({
        duration: 2500,
        position: { x: "right", y: "top" },
        dismissible: true,
    });
}

// inisialisasi awal
initNotyf();

InitFlatFickr();

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

const reinitUI = () => {
    try {
        if (
            window.HSStaticMethods &&
            typeof window.HSStaticMethods.autoInit === "function"
        ) {
            window.HSStaticMethods.autoInit("all");
            if (window.HSSelect) {
                window.HSSelect.getInstance("#select");
            }
        }
    } catch (e) {
        console.warn("FlyonUI reinit gagal:", e);
    }

    // Reinitialize flatpickr after DOM updates
};

// --- hook untuk UI setelah navigasi/DOM update ---
document.addEventListener("livewire:load", () => {
    reinitUI();
    InitFlatFickr();

    if (window.Livewire && typeof window.Livewire.hook === "function") {
        window.Livewire.hook("message.processed", () => {
            reinitUI();
        });
    }
});

document.addEventListener("livewire:navigated", () => {
    reinitUI();
    initNotyf();
    InitFlatFickr();
});

// window.Echo.channel('debug-channel')
//     .listen('.debug.event', (e) => {

//         alert("okeee")
//         console.log("📡 Event diterima:", e);
//     });
