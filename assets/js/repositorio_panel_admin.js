const HOST = "../mc-controllers/panelAdminController.php";

var elemModal; //elemento
var modalGestinarLibro; // instancia

$(document).ready( function () {

    $('.chips-placeholder').chips({
        placeholder: 'Nombre autor',
        secondaryPlaceholder: 'Otro autor',
    });

    $("textarea#i_descripcion").characterCounter();

    modal = $("#modalgestionarLibro");
    modalGestinarLibro = M.Modal.getInstance( modal ); 
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
                        limpiarCampos(); 
                    });
                }
        
            });
            
        }else if( result.dismiss === Swal.DismissReason.cancel ){
            // Swal("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });


});


function gestionarLibro(id){ //funcion para mostrar los datos del libro

    var fd = new FormData()
    fd.append("mode", "getOneById")
    fd.append("id", id)

    fetch(HOST, {
        method:"POST",
        body: fd
    })
    .then( (resp) => resp.json())
    .then( (json) => {
        let autores = "";
        // imprimir datos en el modal
        $("#modal_i_titulo").val(json.libro.titulo);
        $("#modal_i_editorial").val(json.libro.editorial);
        $("#modal_i_edicion").val(json.libro.edicion);
        $("#modal_i_fecha").val(json.libro.fecha);
        $("#modal_i_categoria").val(json.libro.categoria);
        $("#modal_i_materia").val(json.libro.materia);
        $("#modal_i_descripcion").val(json.libro.descripcion);
        $("#modal_i_titulo").val(json.libro.titulo);

        
        for (let index = 0; index < json.autores.length; index++) { // poner en una cadeja los autores
            autores += json.autores[index].nombre;
            let faltantes = json.autores.length - index;
            if(faltantes > 1) autores += ", ";
        }
        $("#modal_i_autores").val(autores);
        modalGestinarLibro.open();

    } );

}


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

function limpiarCampos(){
    $("#form_AgregarLibro")[0].reset(); //resetear formulario
    $("#chips").children(".chip").remove(); // eliminar los chips 
}
