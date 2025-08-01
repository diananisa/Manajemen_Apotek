document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('hidden');
        body.classList.toggle('sidebar-closed');
    });

    // --- User Dropdown ---
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userDropdown');

    userMenuToggle.addEventListener('click', function (e) {
        e.stopPropagation(); // Biar klik di dalam nggak nutup langsung
        userDropdown.classList.toggle('show');
    });

    // Klik di luar -> tutup dropdown
    document.addEventListener('click', function () {
        userDropdown.classList.remove('show');
    });

    window.addEventListener('resize', () => {
        salesChart.resize();
    });
});
