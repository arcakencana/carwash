import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// Ambil data dari blade (window.pendaftarHarian)
const ctx = document.getElementById('pendaftarChart').getContext('2d');

new Chart(ctx, {
    type: 'line', // tipe grafik line
    data: {
        labels: window.pendaftarHarian?.labels || [], // tanggal
        datasets: [{
            label: 'Total Pendaftar Harian',
            data: window.pendaftarHarian?.data || [], // jumlah
            borderColor: 'rgb(37, 99, 235)', // biru
            backgroundColor: 'rgba(37, 99, 235, 0.2)',
            tension: 0.3, // curve smooth
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            tooltip: { mode: 'index', intersect: false },
        },
        scales: {
            x: { display: true, title: { display: true, text: 'Tanggal' } },
            y: { display: true, title: { display: true, text: 'Jumlah Pendaftar' }, beginAtZero: true }
        }
    }
});
