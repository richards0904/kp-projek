// Fungsi untuk update nama toko berdasarkan pilihan idToko saat menambah pesanan
document.addEventListener("DOMContentLoaded", function () {
    var idTokoInput = document.getElementById("idToko");
    var namaTokoInput = document.getElementById("namaToko");

    idTokoInput.addEventListener("input", function () {
        var options = document.getElementById("kodeToko").options;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === idTokoInput.value) {
                namaTokoInput.value =
                    options[i].getAttribute("data-namaToko");
                break;
            } else {
                namaTokoInput.value = ""; // Reset if no match
            }
        }
    });
});

