const HOST = "../mc-controllers/libroController.php";

$(document).ready(function () {
    // cargar autores en el autocomplete
    var fd = new FormData();
    fd.append("mode", "getAutores");

    fetch(HOST, {
        method: "POST",
        body: fd,
    })
        .then((resp) => resp.json())
        .then((json) => {
            // console.log(json);
            $("#i_autor").autocomplete({ data: json, limit: 10 });
        });
});

$("#form_buscar_libro").submit(function (e) {
    e.preventDefault();
    // console.log("");
});

function limpiarCampos() {
    $("#form_buscar_libro")[0].reset();
}

// verificar que no esten vacios todos los campos de busqueda
function verificarCamposBusqueda(){
    if(
        $("#b_titulo").val() == "" ||
        $("#b_autor").val() == "" ||
        $("#b_editorial").val() == "" ||
        $("#b_categoria").val() == "" ||
        $("#b_carrera").val() == "" 
    ){
        Swal.fire("Espera!", "Primero debes introducir algún dato para la busqueda", "info");
    }
}