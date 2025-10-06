import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

export function InitFlatFickr() {
    document.querySelectorAll(".flatpickr").forEach((el) => {
        // destroy kalau sudah ada instance sebelumnya
        if (el._flatpickr) el._flatpickr.destroy();

        // ambil semua data attribute
        const isTimeOnly = el.dataset.timeOnly === "true";
        const isDateOnly = el.dataset.dateOnly === "true";
        const isDateTime = el.dataset.datetime === "true";

        let options = {
            noCalendar: false,
            dateFormat: "d/m/Y H:i",
            enableTime: true,
            time_24hr: true,
        };

        if (isTimeOnly) {
            options = {
                noCalendar: true,
                enableTime: true,
                dateFormat: "H:i",
                time_24hr: true,
            };
        } else if (isDateOnly) {
            options = {
                enableTime: false,
                dateFormat: "d/m/Y",
            };
        } else if (isDateTime) {
            options = {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true,
            };
        }

        flatpickr(el, options);
    });
}
