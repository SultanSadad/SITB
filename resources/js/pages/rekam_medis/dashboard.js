document.addEventListener('DOMContentLoaded', () => {
    const chartLabels = window.chartLabels;
    const yearlyStats = window.yearlyStats;
  
    if (typeof Chart !== 'undefined') {
      const ctx = document.getElementById('yearlyChart');
      if (ctx && chartLabels && yearlyStats) {
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: chartLabels,
            datasets: [{
              label: 'Jumlah Hasil Uji',
              data: yearlyStats,
              backgroundColor: 'rgba(59, 130, 246, 0.5)',
              borderColor: 'rgba(59, 130, 246, 1)',
              borderWidth: 1,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false
          }
        });
      } else {
        console.warn('Element #yearlyChart atau data tidak ditemukan.');
      }
    } else {
      console.error('Chart.js tidak tersedia.');
    }
  });
  