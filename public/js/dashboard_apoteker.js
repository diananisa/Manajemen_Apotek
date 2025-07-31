document.addEventListener('DOMContentLoaded', function () {
    const options = {
        series: [
            CHART_DATA.aman,
            CHART_DATA.hampir,
            CHART_DATA.kadaluarsa
        ],
        chart: {
            height: 350,
            type: 'radialBar'
        },
        colors: ['#28a745', '#ffc107', '#dc3545'],
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '60%'
                },
                track: {
                    show: true,
                    background: '#f1f1f1',
                    strokeWidth: '100%',
                    margin: 0
                },
                dataLabels: {
                    name: {
                        fontSize: '18px'
                    },
                    value: {
                        fontSize: '16px',
                        formatter: function (val) {
                            return Math.round(val); // ← tanpa %
                        }
                    },
                    total: {
                        show: true,
                        label: 'Total Obat',
                        formatter: function () {
                            return CHART_DATA.aman + CHART_DATA.hampir + CHART_DATA.kadaluarsa;
                        }
                    }
                }
            }
        },
        stroke: {
            lineCap: 'round'
        },
        labels: ['Aman', 'Hampir Kadaluarsa', 'Kadaluarsa']
    };

    const chart = new ApexCharts(document.querySelector("#radialChart"), options);
    chart.render();

    // Chart stok produk (Donut)
    const stokDonutOptions = {
        series: [
            STOK_CHART.habis,
            STOK_CHART.bahaya,
            STOK_CHART.menipis,
            STOK_CHART.aman
        ],
        chart: {
            type: 'donut',
            height: 350
        },
        labels: ['Habis', 'Hampir Habis', 'Menipis', 'Banyak'],
        colors: ['#6c757d', '#dc3545', '#ffc107', '#28a745'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return opts.w.config.series[opts.seriesIndex];
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { height: 300 },
                legend: { position: 'bottom' }
            }
        }]
    };

    const stokChart = new ApexCharts(document.querySelector("#stokDonutChart"), stokDonutOptions);
    stokChart.render();
});
