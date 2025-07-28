import flatpickr from "flatpickr";

document.addEventListener('DOMContentLoaded', function () {
    const startDatePicker = flatpickr("#datepicker-range-start", {
        dateFormat: "Y-m-d",
        allowInput: true,
        onChange: function (selectedDates, dateStr) {
            if (selectedDates[0]) {
                endDatePicker.set('minDate', dateStr);
            }
        }
    });

    const endDatePicker = flatpickr("#datepicker-range-end", {
        dateFormat: "Y-m-d",
        allowInput: true,
        onChange: function (selectedDates, dateStr) {
            if (selectedDates[0]) {
                startDatePicker.set('maxDate', dateStr);
            }
        }
    });

    const startInput = document.getElementById('datepicker-range-start');
    const endInput = document.getElementById('datepicker-range-end');

    if (startInput?.value) {
        endDatePicker.set('minDate', startInput.value);
    }

    if (endInput?.value) {
        startDatePicker.set('maxDate', endInput.value);
    }

    const dismissButtons = document.querySelectorAll('[data-dismiss-target]');
    dismissButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-dismiss-target');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.classList.add('hidden');
            }
        });
    });
});
