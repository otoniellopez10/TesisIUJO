$(document).ready(function () {
    window.onload = function () {
        $("#preloader_centrado").fadeOut();
        $("body").removeClass("hidden");
    };

    M.AutoInit();

    $("#btnSolicitar").click(function (e) {
        e.preventDefault();

        Swal.fire(
            "¿Cómo hacerlo?",
            "Debes contactar a los administradores del sistema o encargados de biblioteca del instituto, y solicitar que te concedan los permisos de colaborador.",
            "info"
        );
    });
});
