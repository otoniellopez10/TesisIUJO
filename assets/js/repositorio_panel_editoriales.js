const HOST = "../mc-controllers/editorialController.php";

var elemModal; //elemento
var modalEditarDatosLibro; // instancia
var gbEditorialId;

$(document).ready(function () {
    modal = $("#modalAgregarEditorial");
    modalAgregarEditorial = M.Modal.getInstance(modal);

    modal2 = $("#modalEditarEditorial");
    modalEditarEditorial = M.Modal.getInstance(modal2);

    // iniciar los dataTables
    iniciarDataTables();

    // instancia del Chips al editar un libro
    var elemChipsAutores = $("#editar_chipsAutores");
    instanceChips = M.Chips.getInstance(elemChipsAutores);
});

function agregarEditorial() {
    modalAgregarEditorial.open();
}

function editarEditorial(editorial_id, editorial_nombre) {
    gbEditorialId = editorial_id;
    $("#editar_editorial_nombre").val(editorial_nombre);
    modalEditarEditorial.open();
}

function eliminarEditorial(editorial_id) {
    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea eliminar la editorial?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, eliminar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Eliminando editorial...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        let fd = new FormData();
                        fd.append("mode", "delete");
                        fd.append("editorial_id", editorial_id);

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

$("#formAgregarEditorial").submit(function (e) {
    e.preventDefault();
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
                let fd = new FormData(this);
                fd.append("mode", "insert");

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
});

$("#formEditarEditorial").submit(function (e) {
    e.preventDefault();
    let nombreEditorial = $("#editar_editorial_nombre").val();
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
        text: "Editando editorial...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                let fd = new FormData(this);
                fd.append("mode", "update");
                fd.append("editorial_id", gbEditorialId);

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
});

function limpiarCampos() {
    $("#form_AgregarLibro")[0].reset(); //resetear formulario
}

function iniciarDataTables() {
    // iniciar los dataTables
    $("#tableEditoriales").DataTable({
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

    $("#tableEditoriales_length select").formSelect();
}
