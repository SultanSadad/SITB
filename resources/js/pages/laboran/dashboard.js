import Chart from "chart.js/auto";

const el = document.getElementById("yearlyChart");
if (!el) {
  // Kalau elemen chart tidak ada, hentikan saja
  console.warn("yearlyChart element not found");
} else {
  const monthNames = JSON.parse(el.dataset.months || "[]");
  const yearlyData = JSON.parse(el.dataset.stats || "{}");
  const currentYear = parseInt(el.dataset.currentYear || `${new Date().getFullYear()}`, 10);

  // Safety check
  if (!Array.isArray(monthNames) || !yearlyData || !Array.isArray(yearlyData[currentYear])) {
    console.warn("Chart data is missing or invalid", { monthNames, yearlyData, currentYear });
  } else {
    // ===== Ringkasan =====
    function updateSummary(selectedYear) {
      const data = yearlyData[selectedYear] || [];
      const total = data.reduce((s, v) => s + v, 0);
      const avg = data.length ? Math.round(total / data.length) : 0;

      let maxValue = 0;
      let maxMonthIndex = 0;
      data.forEach((v, i) => { if (v > maxValue) { maxValue = v; maxMonthIndex = i; } });

      const totalEl = document.getElementById("totalTests");
      const avgEl = document.getElementById("avgTests");
      const peakEl = document.getElementById("peakMonth");
      if (totalEl) totalEl.textContent = total.toLocaleString();
      if (avgEl) avgEl.textContent = avg.toLocaleString();
      if (peakEl) peakEl.textContent = monthNames[maxMonthIndex] ?? "-";
    }

    // ===== Chart =====
    const ctx = el.getContext("2d");
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, "rgba(59, 130, 246, 0.8)");
    gradient.addColorStop(1, "rgba(59, 130, 246, 0.1)");

    const chart = new Chart(ctx, {
      type: "line",
      data: {
        labels: monthNames,
        datasets: [{
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
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true, ticks: { precision: 0, font: { family: "'Poppins', sans-serif" } }, grid: { color: "rgba(0,0,0,0.05)" } },
          x: { grid: { display: false }, ticks: { font: { family: "'Poppins', sans-serif" } } },
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
              label: (ctx) => `${ctx.dataset.label}: ${Number(ctx.raw).toLocaleString()} hasil uji`,
            },
          },
        },
        interaction: { mode: "index", intersect: false },
        hover: { mode: "index", intersect: false },
      },
    });

    // Inisialisasi ringkasan
    updateSummary(currentYear);

    // Optional: dropdown tahun
    const selector = document.getElementById("yearSelector");
    if (selector) {
      selector.addEventListener("change", function () {
        const y = this.value;
        chart.data.datasets[0].data = yearlyData[y] || [];
        chart.update();
        updateSummary(y);
      });
    }
  }
}
