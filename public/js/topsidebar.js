document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('hidden');
        body.classList.toggle('sidebar-closed');
    });

    window.addEventListener('resize', () => {
        salesChart.resize();
    });
});
