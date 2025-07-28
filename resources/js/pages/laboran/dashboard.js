import Chart from "chart.js/auto";

// =========================
// DATA & FUNGSI UTAMA
// =========================

// Ambil data dari elemen HTML melalui atribut data
const monthNames = JSON.parse(
    document.getElementById("yearlyChart").dataset.months
);
const yearlyData = JSON.parse(
    document.getElementById("yearlyChart").dataset.stats
);
const currentYear = new Date().getFullYear();

// Fungsi untuk update ringkasan
function updateSummary(selectedYear) {
    const data = yearlyData[selectedYear];
    const total = data.reduce((sum, value) => sum + value, 0);
    const avg = Math.round(total / data.length);

    let maxValue = 0;
    let maxMonthIndex = 0;

    data.forEach((value, index) => {
        if (value > maxValue) {
            maxValue = value;
            maxMonthIndex = index;
        }
    });

    document.getElementById("totalTests").textContent = total.toLocaleString();
    document.getElementById("avgTests").textContent = avg.toLocaleString();
    document.getElementById("peakMonth").textContent =
        monthNames[maxMonthIndex];
}

// =========================
// KONFIGURASI CHART
// =========================

const yearlyChartCtx = document.getElementById("yearlyChart").getContext("2d");
const gradient = yearlyChartCtx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, "rgba(59, 130, 246, 0.8)");
gradient.addColorStop(1, "rgba(59, 130, 246, 0.1)");

const yearlyChart = new Chart(yearlyChartCtx, {
    type: "line",
    data: {
        labels: monthNames,
        datasets: [
            {
                label: "Jumlah Hasil Uji",
                data: yearlyData[currentYear],
                backgroundColor: gradient,
                borderColor: "rgba(37, 99, 235, 1)",
                borderWidth: 2,
                pointBackgroundColor: "rgba(37, 99, 235, 1)",
                pointBorderColor: "#fff",
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.3,
                fill: true,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    font: { family: "'Poppins', sans-serif" },
                },
                grid: {
                    color: "rgba(0, 0, 0, 0.05)",
                },
            },
            x: {
                grid: { display: false },
                ticks: { font: { family: "'Poppins', sans-serif" } },
            },
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: "rgba(30, 58, 138, 0.8)",
                titleFont: { family: "'Poppins', sans-serif", size: 14 },
                bodyFont: { family: "'Poppins', sans-serif", size: 13 },
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: function (context) {
                        return (
                            context.dataset.label +
                            ": " +
                            context.raw.toLocaleString() +
                            " hasil uji"
                        );
                    },
                },
            },
        },
        interaction: { mode: "index", intersect: false },
        hover: { mode: "index", intersect: false },
    },
});

// =========================
// INISIALISASI
// =========================

updateSummary(currentYear);

// Dropdown event (opsional jika ada dropdown tahun)
const selector = document.getElementById("yearSelector");
if (selector) {
    selector.addEventListener("change", function () {
        const selectedYear = this.value;
        yearlyChart.data.datasets[0].data = yearlyData[selectedYear];
        yearlyChart.update();
        updateSummary(selectedYear);
    });
}
