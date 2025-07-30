document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("yearlyChart");
    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.months || "[]");
    const data = JSON.parse(canvas.dataset.stats || "[]");

    if (typeof Chart !== "undefined" && labels.length && data.length) {
        new Chart(canvas, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Jumlah Hasil Uji",
                        data: data,
                        backgroundColor: "rgba(37, 99, 235, 0.6)",
                        borderColor: "rgba(37, 99, 235, 1)",
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    } else {
        console.warn("Chart.js tidak tersedia atau data kosong.");
    }
});
