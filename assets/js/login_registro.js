$(document).ready(function () {
    M.AutoInit();

    // variables
    const host = "../mc-controllers/personaController.php";
    const host2 = "../mc-controllers/usuarioController.php";
    const host3 = "../mc-controllers/loginController.php";

    var usuario_id = null;
    var persona_id = null;

    var cont_form = $("#cont_form");

    var btn_cont_registro = $("#btn_cont_registro");
    var btn_cont_login = $("#btn_cont_login");

    var form_login = $("#form_login");
    var i_login_correo = $("#i_login_correo");
    var i_login_clave = $("#i_login_clave");
    var btn_login = $("#btn_login");

    var form_registro = $("#form_registro");
    var i_cedula = $("#i_cedula");
    var i_nombre = $("#i_nombre");
    var i_apellido = $("#i_apellido");
    var i_correo = $("#i_correo");
    var i_clavenueva = $("#i_clavenueva");
    var i_clavenueva2 = $("#i_clavenueva2");
    var i_telefono = $("#i_telefono");
    var i_persona_tipo = $("#i_persona_tipo");
    var btn_registro = $("#btn_registro");

    window.onload = function () {
        $("#preloader_centrado").fadeOut();
    };

    // ajustes iniciales
    form_registro.hide(0);

    // cambiar los Form cuando se le de a los botones
    btn_cont_registro.click(function (e) {
        e.preventDefault();
        form_login.hide(500);
        form_registro.show(500);
        $("#linea_btn").css("left", "50%");
        $(this).addClass("active");
        btn_cont_login.removeClass("active");
    });
    // cambiar los Form cuando se le de a los botones
    btn_cont_login.click(function (e) {
        e.preventDefault();
        form_registro.hide(500);
        form_login.show(500);
        $(this).addClass("active");
        btn_cont_registro.removeClass("active");
        $("#linea_btn").css("left", "0%");
    });

    // conseguir el modo, si es null es ingresar, si s 2 es registro.
    let params = new URLSearchParams(location.search);
    var mode = params.get("mode");
    if (mode == 2) {
        $("#btn_cont_registro").click();
    }

    /////////////////////////////////////////////
    // ENVIO DE FORMULARIO DE REGISTRO
    /////////////////////////////////////////////
    form_registro.submit(async function (e) {
        e.preventDefault();

        // validar campos del form
        try {
            if (
                i_cedula.val() == "" ||
                i_nombre.val() == "" ||
                i_apellido.val() == "" ||
                i_correo.val() == "" ||
                i_clavenueva.val() == "" ||
                i_clavenueva2.val() == "" ||
                i_telefono.val() == "" ||
                i_persona_tipo.val() == ""
            )
                throw "Faltan campos por completar";
            if (
                i_cedula.val().length < 6 ||
                i_cedula.val().length > 8 ||
                isNaN(i_cedula.val())
            )
                throw "Ingresa una cédula valida";
            if (i_clavenueva.val() != i_clavenueva2.val())
                throw "Las contraseñas no coinciden";
        } catch (e) {
            swal.fire({
                title: "Error",
                text: e,
                icon: "error",
            });
        }
        // fin validar campos

        var data = {
            cedula: i_cedula.val(),
            nombre: i_nombre.val(),
            apellido: i_apellido.val(),
            correo: i_correo.val(),
            clave: i_clavenueva.val(),
            telefono: i_telefono.val(),
            persona_tipo: i_persona_tipo.val(),
        };

        // agregar a la variable fd los datos del formulario
        // let f = this;
        var fd = new FormData(this);
        fd.append("mode", "insert");

        // ejecutar la insersion del usuario (1/2)
        $.post({
            url: host2,
            contentType: false,
            processData: false,
            data: fd,
            dataType: "json",
            success: function (res) {
                if (res.error) {
                    swal.fire("Error", res.message, "error");
                    return;
                } else {
                    usuario_id = res.id;
                    agregarPersona(fd);
                }
            },
            error: function (error) {
                console.error(error.responseText);
                return;
            },
        });
    });

    function agregarPersona(fd) {
        fd.append("usuario_id", usuario_id);
        $.post({
            url: host,
            contentType: false,
            processData: false,
            data: fd,
            dataType: "json",
            success: function (res) {
                if (res.error) {
                    swal.fire("Error", res.message, "error");
                } else {
                    swal.fire({
                        title: "¡Registro exitoso!",
                        text: res.message,
                        icon: "success",
                        button: "Ir al repositorio",
                    }).then(function () {
                        window.location = "../mc/views/repositorio.php";
                    });
                }
            },
            error: function (error) {
                console.error(error);
                return false;
            },
        });
    }

    ////////////////////////////////////////////
    // ENVIO DE FORMULARIO DE LOGIN
    /////////////////////////////////////////////

    form_login.submit(function (e) {
        e.preventDefault();

        let fd = new FormData(this);
        fd.append("mode", "loadOne");

        Swal.fire({
            title: "Iniciando Sesión",
            text: "Espere un momento...",
            confirmButtonColor: $(".btn-primary").css("background-color"),
            confirmButtonText: "Reintentar",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve, reject) => {
                    $.post({
                        url: host3,
                        contentType: false,
                        processData: false,
                        data: fd,
                        dataType: "json",
                        success: function (res) {
                            if (res.usuario == false || res.usuario == null) {
                                reject(res.mensaje);
                            } else {
                                resolve(res);
                            }
                        },
                        error: function (error) {
                            Swal.fire("Error!", error.mensaje, "error");
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
                window.location = "../mc-views/repositorio.php";
            }
        });
    });
});
