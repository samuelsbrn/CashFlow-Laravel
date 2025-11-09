// resources/js/app.js

// 1) Import Laravel default (kalau kamu pakai `php artisan preset` atau starter lain,
//    boleh disesuaikan. Kalau kosong juga nggak apa-apa.)
import './bootstrap'; // kalau kamu gak punya file ini, hapus baris ini

// 2) Import helper alert & chart kita
import './alerts';
import './charts';

// 3) (Opsional) Import Trix editor kalau kamu pakai Trix di form transaksi
//    pastikan di package.json sudah ada "trix"
//    kalau tidak pakai, boleh hapus 3 baris ini
import 'trix';
import 'trix/dist/trix.css';

// 4) Expose Swal ke window kalau SweetAlert2 dipakai dari npm
//    npm i sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// 5) Kalau kamu ingin pakai ApexCharts dari npm:
//    npm i apexcharts
//    dan dibiarkan saja di charts.js karena kita import di sana

console.log('app.js loaded');
