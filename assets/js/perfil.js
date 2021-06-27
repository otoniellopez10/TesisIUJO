const HOST = "../mc-controllers/personaController.php";

var respaldo = [];

$(document).ready(function(){
   
    

    // ocultar boton de submit para editar datos
    $("#cont_btn_submit").slideUp(0);
});


function editarDatos(usuario_id){
    desbloquearInputs();
    $("#cont_btn_submit").slideDown(300);
    $("#u_nombre").focus();
    $("#cont-datos-usuario > .row").addClass("z-depth-4");

    let inputs = $("#formDatosPersonales input:not(#u_rol");

    inputs.each(function(i,v){ //guardar los valores originales en caso de querer cancelar
        respaldo.push(v.value);
    });
}
// editarDatos(30);

function cambiarClave(usuario_id){

}


function cancelarEdicion(){
    $("#cont_btn_submit").slideUp(300);
    $("#cont-datos-usuario > .row").removeClass("z-depth-4");

    let inputs = $("#formDatosPersonales input:not(#u_rol");

    inputs.each(function(i,v){ //reponer los datos originales
        v.value = respaldo[i];
    });

    $("#u_nombre").attr("disabled",true);
    $("#u_apellido").attr("disabled",true);
    $("#u_cedula").attr("disabled",true);
    $("#u_email").attr("disabled",true);
    $("#u_telefono").attr("disabled",true);
}


$("#formDatosPersonales").submit(function(e){
    e.preventDefault();

    if(!validarCampos()){
        return false;
    }

    Swal.fire({
        title:"Confirmación",
        text: "¿Esta seguro que desea actualizar sus datos?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, actualizar"
    }).then((result) => {
        if(result.value == true ){
            Swal.fire({
                title: 'Espere un momento',
                text: 'Actualizando sus datos...',
                confirmButtonColor: $(".btn-primary").css('background-color'),
                confirmButtonText: 'Reintentar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {

                        let fd = new FormData(this);
                        fd.append("mode","update");

                        $.ajax({
                            method: 'POST',
                            url: HOST,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            data: fd,
                            success: function (resp) {
                                if (resp.error) {
                                    reject(resp.message);
                                } else {
                                    resolve(resp);
                                }
                            },
                            error: function (xhr) {
                                console.error(xhr);
                                reject('Ocurrió un problema desconocido al tratar de actualizar sus datos');
                            }
                        });
                    }).catch(function (reason) {
                        Swal.showValidationMessage(reason);
                        Swal.hideLoading();
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
                didOpen: () => Swal.clickConfirm() // Hace clic en el botón de confirmación automáticamente al abrir el modal
            }).then((result) => {
                //console.log(result)
                if (result.value) {
                    let resp = result.value;
                    Swal.fire("Listo!", resp.message, 'success')
                    .then((e) => {
                        location.reload();
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            return false;
        }
    });
});



// /////////////////////////////
// /////////////////////////////
// /////////////////////////////


function desbloquearInputs(){
    $("#u_nombre").attr("disabled",false);
    $("#u_apellido").attr("disabled",false);
    $("#u_cedula").attr("disabled",false);
    $("#u_email").attr("disabled",false);
    $("#u_telefono").attr("disabled",false);
}

function validarCampos(){
    
    let n = $("#u_nombre").val();
    let a = $("#u_apellido").val();
    let c = $("#u_cedula").val();
    let e = $("#u_email").val();
    let t = $("#u_telefono").val();

    try{
        if(n == "" || a == "" || c == "" || e == "") throw "Debes llenar todos los campos";
        if(isNaN(c) || c.length > 8) throw "La cédula no es válida";
        if(t != "" && isNaN(t)) throw "El número de teléfono no es válido";

    }catch(e){
        Swal.fire("Error!", e, "error");
        return false;
    }
    return true;
}

$("#u_nombre, #u_apellido").keypress(function(e){
    var a = /[a-zA-ZñÑáéíóúÁÉÍÓÚ]/;
    validar(e,a); 
    if(this.value.length == 50){
        return false;
    }
});

$("#u_cedula").keypress(function(e){
    var a = /[0-9]/;
    validar(e,a); 
    if(this.value.length == 8){
        return false;
    }
});
$("#u_telefono").keypress(function(e){
    var a = /[0-9]/;
    validar(e,a); 
    if(this.value.length == 11){
        return false;
    }
});



function validar(e,a){
    var key = e.keyCode || e.which;
    var expresion = a;
    var especiales = "8-37-38-46";
    var tecla = String.fromCharCode(key);
    var teclado_especial = false;

    for(var i in especiales){
        if(key == especiales[i]){
            teclado_especial == true;
        }
    }

   if(!expresion.test(tecla) && !teclado_especial){
       e.preventDefault();
        return false;
   }

}