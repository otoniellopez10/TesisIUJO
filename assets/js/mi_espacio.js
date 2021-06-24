const HOST = "../mc-controllers/libroController.php";

function eliminarFavoritos(libro_id){
    Swal.fire({
        title: "Confirmación",
        text: "¿Esta seguro que desea eliminar el libro de favoritos?",
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, eliminar",
    }).then((result) => {
        if (result.value == true) {
            Swal.fire({
                title: "Eliminando libro de favoritos",
                text: "Espere un momento...",
                confirmButtonColor: $(".btn-primary").css("background-color"),
                confirmButtonText: "Reintentar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {
                        let fd = new FormData();
                        fd.append("mode", "deleteFavorito");
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
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Swal.fire("Cancelado", "La solicitud sigue en estado \"Pendiente\"", "info");
        }
    });
}