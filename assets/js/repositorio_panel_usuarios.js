const HOST = "../mc-controllers/personaController.php";

var modalVer, modalVerpersona, gbUsuarioId;

$(document).ready( function () {

    // instancias de modals
    modalVer = $("#modalVerDatosPersona");
    modalVerpersona = M.Modal.getInstance( modalVer );

    modalEditar = $("#modalEditarRol")
    modalEditarUsuario = M.Modal.getInstance( modalEditar );

    
});



function verPersona(id){

    var fd = new FormData()
    fd.append("mode", "getOne")
    fd.append("id", id)

    fetch(HOST, {
        method:"POST",
        body: fd
    })
    .then( (resp) => resp.json())
    .then( (json) => {
        let autores = "";
        // imprimir datos en el modal
        $("#persona_id").val(json.id);
        $("#persona_cedula").val(json.cedula);
        $("#persona_nombre").val(json.nombre);
        $("#persona_apellido").val(json.apellido);
        $("#persona_telefono").val(json.telefono);
        $("#persona_tipo").val(json.tipo);
        $("#persona_email").val(json.email);
        $("#persona_rol").val(json.rol);

        modalVerpersona.open();
    } );
}


function editarPersona(usuario_id){ //editar un usuario por usuario_id
    gbUsuarioId = usuario_id;

    var fd = new FormData()
    fd.append("mode", "getOneByUsuarioId")
    fd.append("usuario_id", usuario_id);

    fetch(HOST, {
        method:"POST",
        body: fd
    })
    .then( (resp) => resp.json())
    .then( (json) => {
        $("#formEditarRol")[0].reset();
        $("#EditarRolNombre").val(json.nombre + " " + json.apellido);

        $("#editarRolSelect option").each(function(){
            if( $(this).val() == json.rol_id ){
                $(this).attr("selected", true);
            }else{
                $(this).attr("selected", false);
            }
        });

        modalEditarUsuario.open();
    } );
}


function desactivarPersona(usuario_id){ // desactivar un usuario por usuario_id

    let fd = new FormData();
    fd.append("mode","desactivar");
    fd.append("usuario_id",usuario_id);

    Swal.fire({
        title:"Confirmación",
        text: "¿Esta seguro que desea desactivar este usuario?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, desactivar"
    }).then((result) => {
        if(result.value == true ){
            Swal({
                title: 'Espere un momento',
                text: 'Desactivando usuario...',
                confirmButtonColor: $(".btn-primary").css('background-color'),
                confirmButtonText: 'Reintentar',
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
                            }
                        });
                    }).catch(function (reason) {
                        Swal.showValidationMessage(reason);
                        Swal.hideLoading();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
                onOpen: () => Swal.clickConfirm() // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, 'success')
                    .then((e) => {
                        window.location.reload();
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}


function activarPersona(usuario_id){
    let fd = new FormData();
    fd.append("mode","activar");
    fd.append("usuario_id",usuario_id);

    Swal.fire({
        title:"Confirmación",
        text: "¿Esta seguro que desea activar este usuario?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, activar"
    }).then((result) => {
        if(result.value == true ){
            Swal({
                title: 'Espere un momento',
                text: 'Activando usuario...',
                confirmButtonColor: $(".btn-primary").css('background-color'),
                confirmButtonText: 'Reintentar',
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
                            }
                        });
                    }).catch(function (reason) {
                        Swal.showValidationMessage(reason);
                        Swal.hideLoading();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
                onOpen: () => Swal.clickConfirm() // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, 'success')
                    .then((e) => {
                        window.location.reload();
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}

// funcion al darle "guardar cambios" del formulario para cambiar el rol del usuario
$("#formEditarRol").submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("mode", "cambiarRol");
    fd.append("usuario_id", gbUsuarioId);

    let mensaje;
    if( $("#editarRolSelect").val() == 2 ) mensaje = "¿Otorgar permisos de colaborador al usuario?";
    else mensaje = "¿Revocar permisos de colaborador al usuario?";


    Swal.fire({
        title:"Confirmación",
        text: mensaje,
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Confirmar"
    }).then((result) => {
        if(result.value == true ){
            Swal({
                title: 'Espere un momento',
                text: 'Actualizando usuario...',
                confirmButtonColor: $(".btn-primary").css('background-color'),
                confirmButtonText: 'Reintentar',
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
                            }
                        });
                    }).catch(function (reason) {
                        Swal.showValidationMessage(reason);
                        Swal.hideLoading();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
                onOpen: () => Swal.clickConfirm() // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                if (result.value) {
                    let resp = result.value;
                    Swal("Listo!", resp.message, 'success')
                    .then((e) => {
                        window.location.reload();
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
});
