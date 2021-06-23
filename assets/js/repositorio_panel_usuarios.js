const HOST = "../mc-controllers/personaController.php";

var modalVer, modalVerpersona, gbUsuarioId;

$(document).ready(function () {
    // instancias de modals
    modalVer = $("#modalVerDatosPersona");
    modalVerpersona = M.Modal.getInstance(modalVer);

    modalEditar = $("#modalEditarRol");
    modalEditarUsuario = M.Modal.getInstance(modalEditar);
});

function verPersona(id) {
    var fd = new FormData();
    fd.append("mode", "getOne");
    fd.append("id", id);

    fetch(HOST, {
        method: "POST",
        body: fd,
    })
        .then((resp) => resp.json())
        .then((json) => {
            modalDatosusuario(json);
            gbUsuarioId = id;
        });
}

function editarPersona(usuario_id) {
    //editar un usuario por usuario_id
    gbUsuarioId = usuario_id;

    var fd = new FormData();
    fd.append("mode", "getOneByUsuarioId");
    fd.append("usuario_id", usuario_id);

    fetch(HOST, {
        method: "POST",
        body: fd,
    })
        .then((resp) => resp.json())
        .then((json) => {
            $("#formEditarRol")[0].reset();
            $("#EditarRolNombre").text(json.nombre + " " + json.apellido);
            $("#EditarRolCedula").text(json.cedula);

            $("#editarRolSelect option").each(function () {
                if ($(this).val() == json.rol_id) {
                    $(this).attr("selected", true);
                } else {
                    $(this).attr("selected", false);
                }
            });

            modalEditarUsuario.open();
        });
}

function desactivarPersona(usuario_id) {
    // desactivar un usuario por usuario_id

    let fd = new FormData();
    fd.append("mode", "desactivar");
    fd.append("usuario_id", usuario_id);

    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea desactivar este usuario?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, desactivar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Desactivando usuario...",
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
}

function activarPersona(usuario_id) {
    let fd = new FormData();
    fd.append("mode", "activar");
    fd.append("usuario_id", usuario_id);

    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea activar este usuario?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, activar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Activando usuario...",
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
}

$("#b_usuario_cedula").keypress(function (e) {
    var a = /[0-9]/;
    validar(e, a);
    if (this.value.length == 8) {
        return false;
    }
});

// enviar formulario de buscar usuario por cedula
$("#formBuscarUsuario").submit(function (e) {
    e.preventDefault();

    let cedula = $("#b_usuario_cedula").val();
    if (cedula.length < 6 || cedula.length > 8) {
        Swal.fire("Error!", "Ingrese una cédula válida", "error");
        return false;
    }

    let fd = new FormData();
    fd.append("mode", "getOneByCedula");
    fd.append("cedula", cedula);

    Swal.fire({
        title: "Espere un momento",
        text: "Buscando usuario...",
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
                $("#b_usuario_cedula").val("");
                Swal.showValidationMessage(reason);
                Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {
        if (result.value) {
            gbUsuarioId = result.value.usuario_id;
            modalDatosusuario(result.value);
        }
    });
});

// funcion al darle al boton de editar en el modal
$("#btnModalEditar").click(function () {
    editarPersona(gbUsuarioId);
});

$("#btnModalDesactivar").click(function () {
    desactivarPersona(gbUsuarioId);
});

$("#btnModalActivar").click(function () {
    activarPersona(gbUsuarioId);
});
// funcion al darle "guardar cambios" del formulario para cambiar el rol del usuario
$("#formEditarRol").submit(function (e) {
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("mode", "cambiarRol");
    fd.append("usuario_id", gbUsuarioId);

    let mensaje;
    if ($("#editarRolSelect").val() == 2)
        mensaje = "¿Otorgar permisos de colaborador al usuario?";
    else mensaje = "¿Revocar permisos de colaborador al usuario?";

    Swal.fire({
        title: "Confirmación",
        text: mensaje,
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Confirmar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Espere un momento",
                text: "Actualizando usuario...",
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

////////////////////////////////////////////
////////////////////////////////////////////
//////////// FUNCIONES EXTRAS //////////////
////////////////////////////////////////////
////////////////////////////////////////////

function validar(e, a) {
    var key = e.keyCode || e.which;
    var expresion = a;
    var especiales = "8-37-38-46";
    var tecla = String.fromCharCode(key);
    var teclado_especial = false;

    for (var i in especiales) {
        if (key == especiales[i]) {
            teclado_especial == true;
        }
    }

    if (!expresion.test(tecla) && !teclado_especial) {
        e.preventDefault();
        return false;
    }
}

function modalDatosusuario(json){
    // imprimir datos en el modal
    $("#persona_id").text(json.id);
    $("#persona_cedula").text(json.cedula);
    $("#persona_nombre").text(json.nombre);
    $("#persona_apellido").text(json.apellido);
    $("#persona_telefono").text(json.telefono);
    $("#persona_tipo").text(json.tipo);
    $("#persona_email").text(json.email);
    $("#persona_rol").text(json.rol);

    $("#b_usuario_cedula").val("");
    $("#btnModalEditar").removeClass("hide");

    if (json.estatus == 1) {
        $("#btnModalDesactivar").removeClass("hide");
    } else $("#btnModalDesactivar").addClass("hide");

    if (json.estatus == 0) {
        $("#btnModalActivar").removeClass("hide");
    } else $("#btnModalActivar").addClass("hide");

    modalVerpersona.open();
}