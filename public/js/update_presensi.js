document.addEventListener("DOMContentLoaded", function () {
    let configEl = document.getElementById("presensiConfig");
    let updateUrl = configEl.dataset.url;
    let csrfToken = configEl.dataset.token;

    let currentId = null;

    document.querySelectorAll('.edit-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentId = this.dataset.id;
            document.getElementById('statusSelect').value = this.dataset.current;
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        });
    });

    document.getElementById('saveStatusBtn').addEventListener('click', function() {
        let status = document.getElementById('statusSelect').value;

        fetch(updateUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ id: currentId, status: status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert("Gagal mengupdate status.");
            }
        })
        .catch(err => alert("Terjadi kesalahan."));
    });
});
