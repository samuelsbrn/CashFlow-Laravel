// resources/js/charts.js

import ApexCharts from 'apexcharts';

document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#incomeExpenseChart');
    if (!el) {
        return; // ga ada chart di halaman ini
    }

    // kita ambil data dari atribut data-*
    // contoh di blade:
    // <div id="incomeExpenseChart"
    //      data-categories='["2025-08","2025-09"]'
    //      data-income='[2000000,1500000]'
    //      data-expense='[500000,750000]'></div>
    const categories = JSON.parse(el.dataset.categories || '[]');
    const income = JSON.parse(el.dataset.income || '[]');
    const expense = JSON.parse(el.dataset.expense || '[]');

    const options = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: {
                show: false
            }
        },
        series: [
            {
                name: 'Income',
                data: income
            },
            {
                name: 'Expense',
                data: expense
            }
        ],
        xaxis: {
            categories: categories
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#16a34a', '#dc2626'],
        legend: {
            position: 'top'
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    // format jadi 1.2jt, 500rb, dll (sederhana)
                    if (val >= 1000000) {
                        return (val / 1000000).toFixed(1) + ' jt';
                    }
                    if (val >= 1000) {
                        return (val / 1000).toFixed(0) + ' rb';
                    }
                    return val;
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return new Intl.NumberFormat('id-ID').format(val);
                }
            }
        }
    };

    const chart = new ApexCharts(el, options);
    chart.render();
});
