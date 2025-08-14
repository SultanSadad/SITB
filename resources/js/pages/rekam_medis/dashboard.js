import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

document.addEventListener("DOMContentLoaded", () => {
  const el = document.getElementById("yearlyChart");
  if (!el) return;

  const monthNames = JSON.parse(el.dataset.labels || "[]");
  const yearlyData = JSON.parse(el.dataset.stats || "{}");
  const currentYear = new Date().getFullYear();
  const dataThisYear = yearlyData[String(currentYear)] || yearlyData[currentYear] || Array(12).fill(0);

  // summary
  const total = dataThisYear.reduce((s, v) => s + (Number(v) || 0), 0);
  const avg = dataThisYear.length ? Math.round(total / dataThisYear.length) : 0;
  let maxVal = -Infinity, maxIdx = 0;
  dataThisYear.forEach((v, i) => { if (v > maxVal) { maxVal = v; maxIdx = i; } });

  const totalEl = document.getElementById("totalTests");
  const avgEl = document.getElementById("avgTests");
  const peakEl = document.getElementById("peakMonth");
  if (totalEl) totalEl.textContent = total.toLocaleString();
  if (avgEl) avgEl.textContent = avg.toLocaleString();
  if (peakEl) peakEl.textContent = monthNames[maxIdx] ?? "-";

  // chart like laboran (line + gradient)
  const ctx = el.getContext("2d");
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, "rgba(59, 130, 246, 0.8)");
  gradient.addColorStop(1, "rgba(59, 130, 246, 0.1)");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: monthNames,
      datasets: [{
        label: "Jumlah Hasil Uji",
        data: dataThisYear,
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
        y: {
          beginAtZero: true, ticks: { precision: 0 },
          grid: { color: "rgba(0,0,0,0.05)" }
        },
        x: { grid: { display: false } },
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: "rgba(30, 58, 138, 0.8)",
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

  // (opsional) kalau nanti ada <select id="yearSelector">, tinggal update data:
  const selector = document.getElementById("yearSelector");
  if (selector) {
    selector.addEventListener("change", function () {
      const y = this.value;
      const arr = yearlyData[y] || Array(12).fill(0);
      const chart = Chart.getChart(el);
      chart.data.datasets[0].data = arr;
      chart.update();

      // update summary
      const t = arr.reduce((s, v) => s + (Number(v) || 0), 0);
      const a = arr.length ? Math.round(t / arr.length) : 0;
      let mV = -Infinity, mI = 0; arr.forEach((v, i) => { if (v > mV) { mV = v; mI = i; } });
      if (totalEl) totalEl.textContent = t.toLocaleString();
      if (avgEl) avgEl.textContent = a.toLocaleString();
      if (peakEl) peakEl.textContent = monthNames[mI] ?? "-";
    });
  }
});
