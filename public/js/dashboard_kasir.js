const ctx = document.getElementById('salesChart').getContext('2d');

// Tentukan label sumbu X sesuai filter
let xAxisLabel = {
    'jam': 'Jam',
    'hari': 'Tanggal',
    'bulan': 'Bulan',
    'tahun': 'Tahun'
}[window.filterType] || 'Bulan';

// Buat chart
new Chart(ctx, {
    type: 'line',
    data: {
        labels: window.salesDataLabels,
        datasets: [{
            label: 'Total Penjualan',
            data: window.salesDataValues,
            fill: true,
            borderColor: 'rgba(0, 123, 255, 1)',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.3,
            pointBackgroundColor: '#007bff',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Biar bisa auto menyesuaikan tinggi-lebar
        resizeDelay: 100,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                }
            },
            x: {
                title: {
                    display: true,
                    text: xAxisLabel
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: context => 'Rp ' + Number(context.raw).toLocaleString('id-ID')
                }
            },
            legend: { display: false }
        }
    }
});
