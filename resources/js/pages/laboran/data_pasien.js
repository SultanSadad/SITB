// resources/js/pages/laboran/data_pasien.js

document.addEventListener("DOMContentLoaded", function () {
    const updateRouteTemplate =
        document.getElementById("route-update")?.value || "";
    const flashSuccess = document.getElementById("flash-success")?.value || "";
    const flashError = document.getElementById("flash-error")?.value || "";

    // Tampilkan notifikasi jika ada
    if (flashSuccess) {
        Swal.fire({ icon: "success", title: "Berhasil", text: flashSuccess });
    }
    if (flashError) {
        Swal.fire({ icon: "error", title: "Gagal", text: flashError });
    }

    // Modal Edit Pasien
    const editButtons = document.querySelectorAll(".btn-edit");
    const modalEdit = document.getElementById("modalEdit");
    const formEdit = document.getElementById("formEdit");
    const inputIdEdit = document.getElementById("id_edit");

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const pasien = JSON.parse(this.getAttribute("data-pasien"));
            if (!pasien) return;

            inputIdEdit.value = pasien.id;
            formEdit.action = updateRouteTemplate.replace(":id", pasien.id);

            document.getElementById("nik_edit").value = pasien.nik || "";
            document.getElementById("no_erm_edit").value = pasien.no_erm || "";
            document.getElementById("nama_edit").value = pasien.nama || "";
            document.getElementById("tgl_lahir_edit").value =
                pasien.tgl_lahir || "";
            document.getElementById("no_hp_edit").value = pasien.no_hp || "";

            modalEdit.showModal();
        });
    });

    // Modal Konfirmasi Verifikasi
    const verifikasiButtons = document.querySelectorAll(".btn-verifikasi");
    verifikasiButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const form = this.closest("form");

            Swal.fire({
                title: "Verifikasi Pasien?",
                text: "Pastikan data pasien sudah benar.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, verifikasi",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Modal Hapus
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const nama = this.getAttribute("data-nama");

            Swal.fire({
                title: `Hapus pasien ${nama}?`,
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e3342f",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Hapus",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-delete-${id}`).submit();
                }
            });
        });
    });

    // Tombol Tambah Pasien
    const btnTambah = document.getElementById("btnTambah");
    const modalTambah = document.getElementById("modalTambah");
    if (btnTambah && modalTambah) {
        btnTambah.addEventListener("click", () => {
            modalTambah.showModal();
        });
    }
});
