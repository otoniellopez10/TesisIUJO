const HOST = "../mc-controllers/repositorioController.php";

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
    console.log("e");
    return;

    var consulta = `SELECT 
                        l.id,
                        l.titulo,
                        l.edicion,
                        l.fecha,
                        l.resumen,
                        l.pdf,
                        e.nombre AS editorial,
                        c.nombre AS carrera,
                        t.nombre AS categoria 
                        FROM libro l
                        JOIN libro_editorial e on e.id = l.editorial
                        JOIN libro_carrera c on c.id = l.carrera
                        JOIN tableCategoria t on t.id = l.categoria WHERE ";`;

    if ($("#i_titulo").val() != "") consulta += "l.titulo ";
});

function limpiarCampos() {
    $("#form_buscar_libro")[0].reset();
}
