const HOST = "../mc-controllers/libroController.php";

var contBuscador = $("#c_form_buscador");
var contResultados = $("#c_resultados_busqueda");
var btnCerrarResultados = $("#btnCerrarResultados");

$(document).ready(function () {
    // cargar autores en el autocomplete
    var fd = new FormData();
    fd.append("mode", "getAutores");

    fetch(HOST, {
        method: "POST",
        body: fd,
    })
        .then((resp) => resp.json())
        .then((json) => {
            // console.log(json);
            $("#i_autor").autocomplete({ data: json, limit: 10 });
        });

    // esconder contenedor de resultados
    contResultados.slideUp(0);
    btnCerrarResultados.slideUp(0);

    $("#tablePrueba").DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay resultados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Límite: _MENU_",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        responsive: true
    
    
    });

    $("#tablePrueba_length select").formSelect();
    
});

$("#form_buscar_libro").submit(function (e) {
    e.preventDefault();

    if(verificarCamposBusqueda()){
        Swal.fire("Espera!", "Primero debes introducir algun dato para la busqueda", "warning");
        return false;
    }

    Swal.fire({
        title: "Espere un momento",
        text: "Cargando libros...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {

                let fd = new FormData(this);
                fd.append("mode","searchConFiltro");

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
                Swal.close()
                Swal.fire("Disculpa", reason, "warning");
                limpiarCampos();
                // Swal.showValidationMessage(reason);
                // Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {
        if (result.value) {
            let resp = result.value;
            imprimirResultadosBusqueda(resp);
            limpiarCampos();
        }
    });
});

function limpiarCampos() {
    $("#form_buscar_libro")[0].reset();
}

// verificar que no esten vacios todos los campos de busqueda
function verificarCamposBusqueda(){
    if(
        $("#b_titulo").val() == "" &&
        $("#b_autor").val() == "" &&
        $("#b_editorial").val() == "" &&
        $("#b_categoria").val() == "" &&
        $("#b_carrera").val() == "" 
    ){
        return true;
    }else{
        return false;
    }
}


function imprimirResultadosBusqueda(data){
    contResultados.children().remove();
    
    data.forEach(json => {

        // darle formato a la fecha
        let f = new Date(json.libro.fecha);
        let dia = f.getDate();
        if (dia < 10) dia = "0" + dia;

        let mes = f.getMonth();
        if (mes < 10) mes = "0" + mes;
        let fecha = dia + "/" + mes + "/" + f.getFullYear();

        contResultados.append(`
        <div class="row valign-wrapper">
        <div class="col s0 m3 hide-on-small-only libro_imagen center-align">
            <img src="../assets/images/libros/libro.png" alt="" class="responsive-img" width="70%">
        </div>

        <div class="col s12 m9  libro_datos">
            <h5 class="titulo teal-text valign-wrapper"><b> ${json.libro.titulo}</b>
            </h5>
            
            <div class="valign-wrapper">
                <b>Calificación: &nbsp;</b>
                <p>${json.calificacion} </p>
            </div>
            
            <div class="valign-wrapper">
                <b>Autor(es): &nbsp;</b>
                <p>${json.autores}</p>
            </div>
            
            <div class="valign-wrapper">
                <b>Editorial: &nbsp;</b>
                <p>${json.libro.editorial}</p>
            </div>
            
            <div class="valign-wrapper">
                <b>Edicion: &nbsp;</b>
                <p>${json.libro.edicion}</p>
            </div>

            <div class="valign-wrapper">
                <b>Fecha de pubicación: &nbsp;</b>
                <p>${fecha}</p>
            </div>

            <div class="valign-wrapper">
                <b>Categoría: &nbsp;</b>
                <p>${json.libro.categoria}</p>
            </div>

            <div class="valign-wrapper">
                <b>Carrera: &nbsp;</b>
                <p>${json.libro.carrera}</p>
            </div>


            <div class="botones-accion ">
                <button class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Agregar a favoritos" style="margin-right: 5px;" onclick="agregarFavoritos(${json.libro.id})"><i class="material-icons ">star</i></button>
                <a href="libro.php?libro_id=${json.libro.id}" class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Ver detalles" target="_blank"><i class="material-icons">visibility</i></a>
            </div>
        </div>
    </div>
    <div class="divider"></div>
        `);
    });

    contBuscador.slideUp(200);
    btnCerrarResultados.slideDown(400);
    contResultados.slideDown(400);

}


function cerrarResultados(){
    btnCerrarResultados.slideUp(300);
    contBuscador.slideDown(300);
    contResultados.slideUp(300);
}