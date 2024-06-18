document.addEventListener("DOMContentLoaded", function () {
    var idBarangInput = document.getElementById("idBarang");
    var namaBarangInput = document.getElementById("namaBarang");

    idBarangInput.addEventListener("input", function () {
        var options = document.getElementById("kodeBarang").options;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === idBarangInput.value) {
                namaBarangInput.value =
                    options[i].getAttribute("data-namabarang");
                break;
            } else {
                namaBarangInput.value = ""; // Reset if no match
            }
        }
    });
});

// Fungsi untuk mencegah user untuk mensubmit data yang tidak ada pada form tambah barang masuk
document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector('form[name="tambahBarangMasuk"]');
    var inputIdBarang = form.querySelector("#idBarang");
    var datalist = form.querySelector("#kodeBarang");

    form.addEventListener("submit", function (event) {
        var optionExists = false;
        var inputValue = inputIdBarang.value.trim().toLowerCase();

        Array.from(datalist.options).forEach(function (option) {
            if (inputValue === option.value.toLowerCase()) {
                optionExists = true;
            }
        });

        if (!optionExists) {
            alert("Harap pilih dari barang yang tersedia.");
            event.preventDefault();
        }
    });
});

// Fungsi untuk mencegah user untuk mensubmit data yang tidak ada pada form tambah detail pesanan
document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector('form[name="tambahDetailPesanan"]');
    var inputIdBarang = form.querySelector("#idBarang");
    var datalist = form.querySelector("#kodeBarang");

    form.addEventListener("submit", function (event) {
        var optionExists = false;
        var inputValue = inputIdBarang.value.trim().toLowerCase();

        Array.from(datalist.options).forEach(function (option) {
            if (inputValue === option.value.toLowerCase()) {
                optionExists = true;
            }
        });

        if (!optionExists) {
            alert("Harap pilih dari barang yang tersedia.");
            event.preventDefault();
        }
    });
});
