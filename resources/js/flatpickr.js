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
            noCalendar: true,
            dateFormat: "Y-m-d",
            enableTime: isTimeOnly || false,
            time_24hr: true,
        };

        // if (isTimeOnly) {
        //     options = {
        //         noCalendar: true,
        //         enableTime: true,
        //         dateFormat: "H:i",
        //         time_24hr: true,
        //     };
        // } else if (isDateOnly) {
        //     options = {
        //         enableTime: false,
        //         dateFormat: "Y-m-d",
        //     };
        // } else if (isDateTime) {
        //     options = {
        //         enableTime: true,
        //         dateFormat: "Y-m-d H:i",
        //         time_24hr: true,
        //     };
        // }

        flatpickr(el, options);
    });
}
