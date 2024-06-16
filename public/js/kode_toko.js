// Fungsi untuk update nama toko berdasarkan pilihan idToko saat menambah pesanan
document.addEventListener("DOMContentLoaded", function () {
    const idTokoSelect = document.getElementById("idToko");
    const namaTokoInput = document.getElementById("namaToko");

    idTokoSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const namaToko = selectedOption.getAttribute("data-namatoko");
        namaTokoInput.value = namaToko;
    });
});

// Fungsi untuk pre-select elemen select di modal edit
$("#editModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var idPesanan = button.data("idpesanan"); // Extract info from data-* attributes
    var idToko = button.data("idtoko");

    var modal = $(this);
    modal.find("#editIdPesanan").val(idPesanan);
    modal.find("#editIdToko").val(idToko);
});
