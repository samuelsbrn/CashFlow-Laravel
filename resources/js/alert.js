// resources/js/alerts.js

// fungsi kecil buat munculin swal
function showAlert(type, message) {
    if (!window.Swal) {
        // kalau sweetalert2 belum ke-load, fallback alert biasa
        alert(message);
        return;
    }

    window.Swal.fire({
        icon: type,
        title: message,
        timer: 2000,
        showConfirmButton: false,
    });
}

// Cara 1: dari elemen yang disisipkan blade
// <div id="flash" data-type="success" data-message="Berhasil tambah data"></div>
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash');
    if (flash) {
        const type = flash.dataset.type || 'success';
        const message = flash.dataset.message || '';
        if (message) {
            showAlert(type, message);
        }
    }
});
