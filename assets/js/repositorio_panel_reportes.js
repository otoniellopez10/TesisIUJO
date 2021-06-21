const HOST = "../mc-controllers/libroController.php";


var tbodyLibros = $("#tbodyLibros");

$(document).ready(function(){
    $("#libros_resultado").slideUp(0);
});
// REPORTES de libros

function reporteLibro(tipoReporte, th){

    let limite = $("#select_limite").val();

    var fd = new FormData();
    fd.append("mode", tipoReporte);
    fd.append("limite", limite);

    Swal({
        title: "Espere un momento",
        text: "Realizando consulta...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {

                fetch(HOST, {
                    method: "POST",
                    body: fd,
                })
                    .then((resp) => resp.json())
                    .then((json) => {
                        if (json.error) {
                            reject(json.message);
                        } else {
                            resolve(json);
                        }
                    });
            }).catch(function (reason) {
                Swal.showValidationMessage(reason);
                Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        onOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {

        if (result.value) {
            let resp = result.value;

            if(resp.error){
                Swal("Error", resp.mensaje, "error");
            }else{
                imprimirResultadosLibro(resp, th);
            }
        }
    });
}

function reporteLibros(){
    let limite = $("#select_limite").val();

    var fd = new FormData();
    fd.append("mode", "getReporteLibros");
    fd.append("limite", limite);

    Swal({
        title: "Espere un momento",
        text: "Realizando consulta...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {

                fetch(HOST, {
                    method: "POST",
                    body: fd,
                })
                    .then((resp) => resp.json())
                    .then((json) => {
                        if (json.error) {
                            reject(json.message);
                        } else {
                            resolve(json);
                        }
                    });
            }).catch(function (reason) {
                Swal.showValidationMessage(reason);
                Swal.hideLoading();
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
        onOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {

        if (result.value) {
            let resp = result.value;

            if(resp.error){
                Swal("Error", resp.mensaje, "error");
            }else{
                let activos = resp.activos[0].cantidad
                let desactivados = resp.desactivados[0].cantidad

                Swal("Reporte de libros", `El sistema cuenta con ${activos} libros activos y ${desactivados} en modo deshabilitado.`, "info");
            }
        }
    });
    // Swal("Informe de libros", "Libros activos: 9\n Libros Desactivados: 3", "info");
}


// funcion para imprimir los datos devueltos de la consulta para el reporte
function imprimirResultadosLibro(json, textoTh){

    // limpiar tabla
    tbodyLibros.children().remove();
    
    json.forEach( (libro,index) => {
        let cantidad = "";
        if(textoTh == "Calificación"){
            let x = libro.cantidad;
            let y = 5;
            while(y > 0){
                console.log("y: " + y);
                if(x > 1)               cantidad = cantidad + "<i class ='material-icons yellow-text text-darken-1'>star</i>";
                else if(x > 0 && x < 1) cantidad = cantidad + "<i class ='material-icons yellow-text text-darken-1'>star_half</i>";
                else cantidad = cantidad + "<i class ='material-icons yellow-text text-darken-1'>star_border</i>";
                x -= 1;
                y -= 1;
            }
        }else cantidad = libro.cantidad;

        let f = new Date(libro.fecha);
                let dia = f.getDate();
                if (dia < 10) dia = "0" + dia;

                let mes = f.getMonth();
                if (mes < 10) mes = "0" + mes;
                let fecha = dia + "/" + mes + "/" + f.getFullYear();
        tbodyLibros.append(`
        <tr>
            <td class="libro_titulo"> ${index+1} </td>
            <td class="libro_titulo"> ${libro.titulo} </td>
            <td> ${libro.editorial} </td>
            <td> ${libro.edicion} </td>
            <td> ${cantidad} </td>
            <td class="td-actions  text-right">
                <a href="libro.php?libro_id=${libro.id}" class="btn-flat btn-accion" title="Ver detalles"  data-toggle="tooltip" data-placement="top">
                <i class="material-icons cyan-text">visibility</i>
                </a>
            </td>
        </tr>
        `);
        $("#thResultado").text(textoTh);
    });

    $("#libros_resultado").slideDown(600);
    $("#botonesReportes").slideUp(600);
    $("#formBuscarLibro").slideUp(600);
}


// boton de volver en los reportes 
function cerrarReportes(){
    $("#libros_resultado").slideUp(400,function(){
        tbodyLibros.children().remove();
    });
    $("#botonesReportes").slideDown(400);
    $("#formBuscarLibro").slideDown(400);
}