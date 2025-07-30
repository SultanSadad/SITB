document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi flatpickr untuk input tanggal mulai
    const startDatePicker = flatpickr("input[name='start']", {
        dateFormat: "Y-m-d",
        allowInput: true,
        onChange: function (selectedDates, dateStr) {
            if (selectedDates[0]) {
                endDatePicker.set("minDate", dateStr);
            }
        },
    });

    // Inisialisasi flatpickr untuk input tanggal akhir
    const endDatePicker = flatpickr("input[name='end']", {
        dateFormat: "Y-m-d",
        allowInput: true,
        onChange: function (selectedDates, dateStr) {
            if (selectedDates[0]) {
                startDatePicker.set("maxDate", dateStr);
            }
        },
    });

    // Ambil elemen input yang sudah punya nilai awal
    const startInput = document.querySelector('input[name="start"]');
    const endInput = document.querySelector('input[name="end"]');

    if (startInput && startInput.value) {
        endDatePicker.set("minDate", startInput.value);
    }

    if (endInput && endInput.value) {
        startDatePicker.set("maxDate", endInput.value);
    }

    // Dismiss notifikasi
    const dismissButton = document.querySelector(".p-4.mb-4 button");
    if (dismissButton) {
        dismissButton.addEventListener("click", () => {
            dismissButton.parentElement.classList.add("hidden");
        });
    }
});
