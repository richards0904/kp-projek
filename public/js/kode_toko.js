// Fungsi untuk update nama toko berdasarkan pilihan idToko saat menambah pesanan
document.addEventListener("DOMContentLoaded", function () {
    var idTokoInput = document.getElementById("idTokoTambah");
    var namaTokoInput = document.getElementById("namaTokoTambah");

    idTokoInput.addEventListener("input", function () {
        var options = document.getElementById("kodeToko").options;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === idTokoInput.value) {
                namaTokoInput.value = options[i].getAttribute("data-namaToko");
                break;
            } else {
                namaTokoInput.value = ""; // Reset if no match
            }
        }
    });
});

// Fungsi untuk mencegah user untuk mensubmit data yang tidak ada pada form tambah pesan
document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector('form[name="formTambahPesan"]');
    var inputIdToko = form.querySelector("#idTokoTambah");
    var datalist = form.querySelector("#kodeToko");

    form.addEventListener("submit", function (event) {
        var optionExists = false;
        var inputValue = inputIdToko.value.trim().toLowerCase();

        Array.from(datalist.options).forEach(function (option) {
            if (inputValue === option.value.toLowerCase()) {
                optionExists = true;
            }
        });

        if (!optionExists) {
            alert("Harap pilih dari toko yang tersedia.");
            event.preventDefault();
        }
    });
});
