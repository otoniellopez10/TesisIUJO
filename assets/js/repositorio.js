const HOST = "../mc-controllers/libroController.php";

var contBuscador = $("#c_form_buscador");
var contResultados = $("#contResultados");
var tableResultados = $("#tableResultados");
var tbodyResultados = $("#tbodyResultados");
var btnCerrarResultados = $("#btnCerrarResultados");

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
            $("#b_autor").autocomplete({ data: json, limit: 10 });
        });

    // esconder contenedor de resultados
    contResultados.slideUp(0);
    btnCerrarResultados.slideUp(0);
});

$("#form_buscar_libro").submit(function (e) {
    e.preventDefault();

    if (verificarCamposBusqueda()) {
        Swal.fire(
            "Espera!",
            "Primero debes introducir algun dato para la busqueda",
            "warning"
        );
        return false;
    }

    Swal.fire({
        title: "Espere un momento",
        text: "Cargando libros...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                let fd = new FormData(this);
                fd.append("mode", "searchConFiltro");

                $.ajax({
                    method: "POST",
                    url: HOST,
                    contentType: false,
                    processData: false,
                    data: fd,
                    dataType: "json",
                    success: function (res) {
                        if (res.error) {
                            reject(res.message);
                        } else {
                            resolve(res);
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        return false;
                    },
                });
            }).catch(function (reason) {
                Swal.close();
                Swal.fire("Disculpa", reason, "warning");
                limpiarCampos();
                // Swal.showValidationMessage(reason);
                // Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {
        if (result.value) {
            let resp = result.value;
            imprimirResultadosBusqueda(resp);
            limpiarCampos();
        }
    });
});

function agregarFavoritos(libro_id) {
    Swal.fire({
        title: "Espere un momento",
        text: "Cargando solicitud...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                let fd = new FormData();
                fd.append("mode", "agregarFavoritos");
                fd.append("libro_id", libro_id);

                $.ajax({
                    method: "POST",
                    url: HOST,
                    contentType: false,
                    processData: false,
                    data: fd,
                    dataType: "json",
                    success: function (res) {
                        if (res.error) {
                            reject(res.message);
                        } else {
                            resolve(res);
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        return false;
                    },
                });
            }).catch(function (reason) {
                Swal.showValidationMessage(reason);
                Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {
        if (result.value) {
            let resp = result.value;
            Swal.fire("Listo!", resp.message, "success");
        }
    });
}

function limpiarCampos() {
    $("#form_buscar_libro")[0].reset();
}

// verificar que no esten vacios todos los campos de busqueda
function verificarCamposBusqueda() {
    if (
        $("#b_titulo").val() == "" &&
        $("#b_autor").val() == "" &&
        $("#b_editorial").val() == "" &&
        $("#b_categoria").val() == "" &&
        $("#b_carrera").val() == ""
    ) {
        return true;
    } else {
        return false;
    }
}

function imprimirResultadosBusqueda(data) {
    tableResultados.DataTable().clear().destroy();
    let contador = 1;
    data.forEach((json) => {
        tbodyResultados.append(`
            <tr>
                <td> ${contador} </td>
                <td class="libro_titulo"> ${json.libro.titulo} </td>
                <td> ${json.libro.editorial} </td>
                <td> ${json.libro.edicion} </td>
                <td> ${json.libro.fecha} </td>
                <td> ${json.libro.categoria} </td>
                <td class="td-actions valign-wrapper">
                    <a href="libro.php?libro_id=${json.libro.id}" class="btn-flat btn-accion" title="Ver detalles"  data-toggle="tooltip" data-placement="top">
                        <i class="material-icons cyan-text">visibility</i>
                    </a>
                    <button class="btn-flat btn-accion" title="Agregar a favoritos"  data-toggle="tooltip" data-placement="top" onclick="agregarFavoritos(${json.libro.id})">
                        <i class="material-icons yellow-text text-darken-1">star</i>
                    </button>
                </td>
            </tr>
        `);

        contador++;
    });

    // convertir en dataTable
    tableResultados.DataTable({
        language: {
            decimal: "",
            emptyTable: "No hay resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 Entradas",
            infoFiltered: "(Filtrado de _MAX_ total entradas)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Límite: _MENU_",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
        responsive: true,
    });

    $("#tableResultados_length select").formSelect();

    contBuscador.slideUp(200);
    btnCerrarResultados.slideDown(400);
    contResultados.slideDown(400);
}

function cerrarResultados() {
    btnCerrarResultados.slideUp(300);
    contBuscador.slideDown(300);
    contResultados.slideUp(300);
}

// buscar libro si asi se requiere (por get que viene del index)
let params = new URLSearchParams(location.search);
var searchLibro = params.get("i_buscador");
if (searchLibro != null) {
    $("#nav a[href='#test5']").addClass("active");
    $("#b_titulo").val(searchLibro);
    $("#btnBuscar").click();
} else {
    $("#nav a[href='#test1']").addClass("active");
}
