const HOST = "../mc-controllers/panelAdminController.php";

var elemModal; //elemento
var modalVerDatosLibro; // instancia
var modalEditarDatosLibro; // instancia
var idLibro;

$(document).ready(function () {
    // iniciar los chips para agregar autores en "agregar libro"
    $(".chips-placeholder").chips({
        placeholder: "Nombre autor",
        secondaryPlaceholder: "Otro autor",
    });

    // serear un maximo de fecha para ls input date.
    let fechaDate = new Date();
    $("#i_fecha").attr("max", fechaDate.toISOString().split("T")[0]);

    // iniciar el contador de caracteres a la i_resumen
    $("textarea#i_resumen").characterCounter();

    // instancias de modals
    modal = $("#modalVerDatosLibro");
    modal.modal({});
    modalVerDatosLibro = M.Modal.getInstance(modal);

    modal2 = $("#modalEditarDatosLibro");
    modalEditarDatosLibro = M.Modal.getInstance(modal2);
});

$("#form_AgregarLibro").submit(function (e) {
    e.preventDefault();

    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea agregar este libro?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, agregar",
    }).then((result) => {
        if (result.value == true) {
            Swal({
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
                        fd.append("mode", "insert");
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
                onOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
});

function verDatosLibro(id) {
    //funcion para mostrar los datos del libro
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
            $("#modal_i_titulo").val(json.libro.titulo);
            $("#modal_i_editorial").val(json.libro.editorial);
            $("#modal_i_edicion").val(json.libro.edicion);

            $("#modal_i_carrera").val(json.libro.carrera);
            $("#modal_i_categoria").val(json.libro.categoria);
            $("#modal_i_resumen").val(json.libro.resumen);
            $("#modal_i_titulo").val(json.libro.titulo);

            // imprimir autores
            for (let index = 0; index < json.autores.length; index++) {
                // poner en una cadeja los autores
                autores += json.autores[index].nombre;
                let faltantes = json.autores.length - index;
                if (faltantes > 1) autores += ", ";
            }
            $("#modal_i_autores").val(autores);

            let fecha = new Date(json.libro.fecha);
            let dia = fecha.getDate();
            let mes = fecha.getMonth() + 1;
            if (dia < 10) dia = "0" + fecha.getDate();
            if (mes + 1 < 10) mes = "0" + (fecha.getMonth() + 1);

            // formatear fecha
            fecha = `${dia}/${mes}/${fecha.getFullYear()}`;
            $("#modal_i_fecha").val(fecha);

            modalVerDatosLibro.open();
            idLibro = json.libro.id;
        });
}

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
            $("#editar_editorial").val(json.libro.editorial);
            $("#editar_edicion").val(json.libro.edicion);
            $("#editar_carrera").val(json.libro.carrera);
            $("#editar_categoria").val(json.libro.categoria);
            $("#editar_resumen").val(json.libro.resumen);
            $("#editar_titulo").val(json.libro.titulo);
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
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, actualizar",
    }).then((result) => {
        if (result.value == true) {
            Swal({
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
                onOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
});

function desactivarLibro(id) {
    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea desactivar este libro?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, desactivar",
    }).then((result) => {
        if (result.value == true) {
            Swal({
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
                onOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, "success").then((e) => {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}

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
