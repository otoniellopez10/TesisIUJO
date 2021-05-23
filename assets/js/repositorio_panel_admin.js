const HOST = "../mc-controllers/panelAdminController.php";

$(document).ready( function () {

    $('.chips-placeholder').chips({
        placeholder: 'Nombre autor',
        secondaryPlaceholder: 'Otro autor',
    });

});


$("#form_AgregarLibro").submit(function(e){
    e.preventDefault();

    Swal.fire({
        title:"Confirmación",
        text: "¿Esta seguro que desea agregar este libro?",
        type: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, agregar"
    }).then((result) => {
        if(result.value == true ){
            Swal({
                title: 'Espere un momento',
                text: 'Cargando libro al sistema...',
                confirmButtonColor: $(".btn-primary").css('background-color'),
                confirmButtonText: 'Reintentar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        var elem = $("#chips");
                        var chip = M.Chips.getInstance(elem);

                        let chipsData = chip.chipsData;
                        let chips = chipsData.map(function(e){ return e.tag;})


                        let fd = new FormData(this);
                        fd.append("mode","insert");
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
                        $("#form_AgregarLibro")[0].reset(); //resetear formulario
                        $("#chips").children(".chip").remove(); // eliminar los chips 
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });


});


// validar los campos del formulario para verificar si no estan 
// vacios y desbloquear el boton de confirmar 
var btnAgregarLibro = $("#btnAgregarLibro");
$("#i_titulo, #i_editorial, #i_edicion, #i_fecha, #i_categoria, #i_materia, #i_descripcion, #i_pdf").on("change keypress", function(){
    let elem = $("#chips");
    let chip = M.Chips.getInstance(elem);                    
    let chipsData = chip.chipsData;
    if( 
        $("#i_titulo").val() == "" ||
        $("#i_editorial").val() == "" ||
        $("#i_edicion").val() == "" ||
        $("#i_fecha").val() == "" ||
        $("#i_categoria").val() == "" ||
        $("#i_materia").val() == "" ||
        $("#i_descripcion").val() == "" ||
        $("#i_pdf").val() == "" ||
        chipsData.length == 0
    ){
        btnAgregarLibro.addClass("disabled");
    }else{
        btnAgregarLibro.removeClass("disabled");
    }
                        
}); 
