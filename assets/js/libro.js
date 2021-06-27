const HOST = "../mc-controllers/libroController.php";

var gbLibroId;

$(document).ready(function () {
    modal = $("#modalCalificarLibro");
    modalCalificarLibro = M.Modal.getInstance(modal);
    // modalCalificarLibro.open();
});


// funcion para consultar si el usuario ha comentado el libro, y si lo quiere volver a editar o eliminar
function calificarLibro(libro_id){
    
    var fd = new FormData();
    fd.append("mode", "getComentarioByUsuarioId");
    fd.append("libro_id", libro_id);
    
    fetch(HOST,{
        method:"POST",
        body: fd
    }).then((resp) => resp.json())
        .then( (resp) => {
            // console.log(resp);
            if(resp.error){
                Swal.fire("Error", resp.message, "error");
                return false;
            }else if(resp.estatus == 2){
                Swal.fire({
                    icon:"question",
                    title: `Libro calificado`,
                    text: `Ya has calificado este libro con ${resp.comentario.calificacion} estrelllas, ¿deseas cambiar tu calificación?`,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Si, cambiar`,
                    denyButtonText: `Eliminar`,
                    denyButtonColor: "",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        gbLibroId = libro_id;
                        modalCalificarLibro.open();
                    } else if (result.isDenied) {
                        deleteComentario(libro_id);
                    }
                })
                
            }else if(resp.estatus == 1){
                gbLibroId = libro_id;
                modalCalificarLibro.open();
            }
        });

}

// funcion para borrar un comentario
function deleteComentario(libro_id){

    Swal.fire({
        title: "Espere un momento",
        text: "Eliminando comentario...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                var fd = new FormData();
                fd.append("mode", "deleteComentario");
                fd.append("libro_id", libro_id);

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
}

function leerPDF(libro_id){
    let fd = new FormData();
    fd.append("mode","leerPDF");
    fd.append("libro_id",libro_id);

    fetch(HOST,{
        method:"POST",
        body: fd
    });
}

function descargarPDF(libro_id){
    let fd = new FormData();
    fd.append("mode","descargarPDF");
    fd.append("libro_id",libro_id);

    fetch(HOST,{
        method:"POST",
        body: fd
    }).then((data) => data.json())
        .then((data) => console.log(data));
}

// formulario al calificar libro
$("#formCalificarLibro").submit(function(e){
    e.preventDefault();

    Swal.fire({
        title: "Espere un momento",
        text: "Publicando tu comentario...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                let fd = new FormData(this);
                fd.append("mode", "setComentario");
                fd.append("libro_id", gbLibroId);

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
})


// funcion para filtrar libros
$("#form_buscar_libro").submit(function(e){
    e.preventDefault();
    verificarCamposBusqueda();
})

// funcion al darle a una estrella
$("#formCalificarLibro .estrellas p").click(function(){
    let estrellas = $("#formCalificarLibro .estrellas p");

    let valor = $(this).attr("valor");
    $("#i_numeroEstrellas").val(valor);
    for (let index = 0; index < 5; index++) {
        if(index < valor)
            $(estrellas[index]).children("i").text("star");
        else
            $(estrellas[index]).children("i").text("star_border");
    }
});

