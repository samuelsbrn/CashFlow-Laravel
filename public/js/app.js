document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts !== 'undefined') {
        const el = document.querySelector('#chart-keuangan');
        if (el) {
            const raw = window.dashboardChart || [];

            const categories = raw.length
                ? raw.map(r => r.month_label || r.month || 'Bulan')
                : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];

            const income = raw.length
                ? raw.map(r => Number(r.total_income) || 0)
                : [900000, 1200000, 1000000, 1500000, 1300000, 1200000];

            const expense = raw.length
                ? raw.map(r => Number(r.total_expense) || 0)
                : [400000, 350000, 300000, 550000, 420000, 480000];

            const chart = new ApexCharts(el, {
                chart: {
                    type: 'area',
                    height: 240,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                series: [
                    { name: 'Pemasukan', data: income },
                    { name: 'Pengeluaran', data: expense }
                ],
                xaxis: {
                    categories: categories,
                    labels: {
                        style: { colors: '#94a3b8' }
                    },
                    axisBorder: { color: '#e2e8f0' },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8' }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#7c3aed', '#f43f5e'],      // ungu & pink
                fill: {
                    type: 'solid',
                    opacity: 0.15
                },
                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 3
                },
                legend: {
                    position: 'bottom',
                    labels: { colors: '#64748b' }
                }
            });

            chart.render();
        }
    }
});
