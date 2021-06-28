const HOST = "../mc-controllers/libroController.php";
const HOST2 = "../mc-controllers/editorialController.php";

var elemModal; //elemento
var modalVerDatosLibro; // instancia
var modalEditarDatosLibro; // instancia
var idLibro;

$(document).ready(function () {
    // iniciar los chips para agregar autores en "agregar libro"
    $(".chips-placeholder").chips({
        placeholder: "Autor(es)",
        secondaryPlaceholder: "Otro autor",
    });

    // serear un maximo de fecha para ls input date.
    let fechaDate = new Date();
    $("#i_fecha").attr("max", fechaDate.toISOString().split("T")[0]);

    // iniciar el contador de caracteres a la i_resumen
    $("textarea#i_resumen").characterCounter();

    // instancias de modals
    modal2 = $("#modalEditarDatosLibro");
    modalEditarDatosLibro = M.Modal.getInstance(modal2);

    modal3 = $("#modalAgregarEditorial");
    modalAgregarEditorial = M.Modal.getInstance(modal3);

    // iniciar los dataTables
    iniciarDataTables();
});

$("#form_AgregarLibro").submit(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea agregar este libro?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, agregar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Cargando libro al sistema...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        var elem = $("#chips");
                        var chip = M.Chips.getInstance(elem);

                        let chipsData = chip.chipsData;
                        let chips = chipsData.map(function (e) {
                            return e.tag;
                        });

                        let fd = new FormData(this);
                        fd.append("mode", "insertColaborador");
                        fd.append("autores", chips);

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
                    Swal.fire("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
});

function editarLibro(id) {
    idLibro = "";
    var fd = new FormData();
    fd.append("mode", "getOneById");
    fd.append("id", id);

    fetch(HOST, {
        method: "POST",
        body: fd,
    })
        .then((resp) => resp.json())
        .then((json) => {
            let autores = "";
            // imprimir datos en el modal
            $("#editar_titulo").val(json.libro.titulo);
            $("#editar_resumen").val(json.libro.resumen);

            // SELECT EDITORIAL
            $("#editar_editorial option").each(function () {
                if ($(this).attr("value") == json.libro.codEditorial) {
                    $(this).attr("selected", true);
                } else {
                    $(this).attr("selected", false);
                }
            });
            $("#editar_editorial").formSelect();

            // SELECT EDICION
            $("#editar_edicion option").each(function () {
                if ($(this).attr("value") == json.libro.edicion) {
                    $(this).attr("selected", true);
                } else {
                    $(this).attr("selected", false);
                }
            });
            $("#editar_edicion").formSelect();

            // SELECT CARRERA
            $("#editar_carrera option").each(function () {
                if ($(this).attr("value") == json.libro.codCarrera) {
                    $(this).attr("selected", true);
                } else {
                    $(this).attr("selected", false);
                }
            });
            $("#editar_carrera").formSelect();

            // SELECT CATEGORIA
            $("#editar_categoria option").each(function () {
                if ($(this).attr("value") == json.libro.codCategoria) {
                    $(this).attr("selected", true);
                } else {
                    $(this).attr("selected", false);
                }
            });
            $("#editar_categoria").formSelect();

            // $("#editar_editorial").val(json.libro.editorial);
            // $("#editar_edicion").val(json.libro.edicion);
            // $("#editar_carrera").val(json.libro.carrera);
            // $("#editar_categoria").val(json.libro.categoria);

            let fechaDate = new Date();
            let fecha = new Date(json.libro.fecha);
            $("#editar_fecha").attr(
                "max",
                fechaDate.toISOString().split("T")[0]
            );
            $("#editar_fecha").val(fecha.toISOString().split("T")[0]);

            // for (let index = 0; index < json.autores.length; index++) { // poner en una cadeja los autores
            //     autores += json.autores[index].nombre;
            //     let faltantes = json.autores.length - index;
            //     if(faltantes > 1) autores += ", ";
            // }
            // $("#editar_autores").val(autores);
            modalEditarDatosLibro.open();
            idLibro = json.libro.id;
        });
}

// enviarel formulario de editar libro
$("#formEditarDatosLibro").submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("mode", "update");
    fd.append("id", idLibro);

    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea actualizar este libro?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, actualizar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Desactivando libro...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
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
                    Swal.fire("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
});

function desactivarLibro(id) {
    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea desactivar este libro?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, desactivar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Desactivando libro...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        let fd = new FormData();
                        fd.append("mode", "desactivarLibro");
                        fd.append("id", id);

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
                    Swal.fire("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}

function activarLibro(id) {
    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea activar este libro?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, activar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Activando libro",
                text: "Espere un momento...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        let fd = new FormData();
                        fd.append("mode", "activarLibro");
                        fd.append("id", id);

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
                    Swal.fire("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}

function agregarEditorial() {
    modalAgregarEditorial.open();
}

$("#btnAgregarEditorial").click(function () {
    let nombreEditorial = $("#editorial_nombre").val();
    if (nombreEditorial.length == 0) {
        Swal.fire(
            "Error!",
            "Debes ingresar el nombre de la editorial",
            "error"
        );
        return false;
    }

    Swal.fire({
        title: "Espere un momento",
        text: "Agregando editorial...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                let fd = new FormData();
                fd.append("mode", "insert");
                fd.append("editorial", nombreEditorial);

                $.ajax({
                    method: "POST",
                    url: HOST2,
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
            modalAgregarEditorial.close(); // cerrar el modal
            let editorial = $("#editorial_nombre").val(); // guardar nombre de la editorial
            $("#editorial_nombre").val(""); // limpiar el campo
            Swal.fire("Listo!", resp.message, "success");

            // agregar la editorial al select y ponerla seleccionada
            $("select#i_editorial").append(
                `<option value="${resp.esitorial_id}" selected> ${editorial} </option>`
            );
            $("select#i_editorial").formSelect();
        }
    });
});

// validar los campos del formulario para verificar si no estan
// vacios y desbloquear el boton de confirmar
var btnAgregarLibro = $("#btnAgregarLibro");
$(
    "#i_titulo, #i_editorial, #i_edicion, #i_fecha, #i_carrera, #i_categoria, #i_resumen, #i_pdf"
).on("change keypress", function () {
    let elem = $("#chips");
    let chip = M.Chips.getInstance(elem);
    let chipsData = chip.chipsData;
    if (
        $("#i_titulo").val() == "" ||
        $("#i_editorial").val() == "" ||
        $("#i_edicion").val() == "" ||
        $("#i_fecha").val() == "" ||
        $("#i_carrera").val() == "" ||
        $("#i_categoria").val() == "" ||
        $("#i_resumen").val() == "" ||
        $("#i_pdf").val() == "" ||
        chipsData.length == 0
    ) {
        btnAgregarLibro.addClass("disabled");
    } else {
        btnAgregarLibro.removeClass("disabled");
    }
});

function limpiarCampos() {
    $("#form_AgregarLibro")[0].reset(); //resetear formulario
    $("#chips").children(".chip").remove(); // eliminar los chips
}

function formatoFecha(fecha) {
    fecha = new Date(fecha);
    let dia = fecha.getDate();
    let mes = "0" + (fecha.getMonth() + 1);
    let year = fecha.getFullYear();
    fecha = `${dia}/${mes}/${year}`;
    console.log(fecha);
    return fecha;
}

function iniciarDataTables() {
    // iniciar los dataTables
    $("#tableLibros, #tableLibrosDesactivados").DataTable({
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

    $(
        "#tableLibros_length select, #tableLibrosDesactivados_length select"
    ).formSelect();
}
