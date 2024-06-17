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
