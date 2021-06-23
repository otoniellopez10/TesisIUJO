const HOST = "../mc-controllers/libroController.php";
const HOST2 = "../mc-controllers/personaController.php";


var tbodyLibros = $("#tbodyLibros");
var tbodyUsuarios = $("#tbodyUsuarios");

$(document).ready(function(){
    $("#libros_resultado").slideUp(0);
    $("#usuarios_resultado").slideUp(0);
});

///////////////////////////////////////////////////
////////// REPORTES de libros y suarios //////////
/////////////////////////////////////////////////

// reporte para libros
function reporte(tipoReporte, th, destino){
    let controller;
    let limite = $("#select_limite").val();

    if(destino == "libro" ) controller = HOST;
    else if(destino == "usuario") controller = HOST2;

    var fd = new FormData();
    fd.append("mode", tipoReporte);
    fd.append("limite", limite);

    Swal.fire({
        title: "Espere un momento",
        text: "Realizando consulta...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {

                fetch(controller, {
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
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {

        if (result.value) {
            let resp = result.value;

            if(resp.error){
                Swal.fire("Error", resp.mensaje, "error");
            }else{
                if(destino == "libro") imprimirResultadosLibro(resp, th);
                else if(destino == "usuario") imprimirResultadosUsuario(resp, th);
            }
        }
    });
}

// cantidad de libros en el sistema (activos y desactivados)
function reporteLibros(){
    let limite = $("#select_limite").val();

    var fd = new FormData();
    fd.append("mode", "getReporteLibros");
    fd.append("limite", limite);

    Swal.fire({
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
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {

        if (result.value) {
            let resp = result.value;

            if(resp.error){
                Swal.fire("Error", resp.mensaje, "error");
            }else{
                let activos = resp.activos[0].cantidad
                let desactivados = resp.desactivados[0].cantidad

                Swal.fire("Reporte de libros", `El sistema cuenta con ${activos} libros activos y ${desactivados} en modo deshabilitado.`, "info");
            }
        }
    });
}

// funcion para imprimir los datos devueltos de la consulta para el reporte de libros
function imprimirResultadosLibro(json, textoTh){

    // limpiar tabla
    tbodyLibros.children().remove();
    
    json.forEach( (libro,index) => {
        let cantidad = "";
        if(textoTh == "Calificación"){
            let x = libro.cantidad;
            let y = 5;
            while(y > 0){
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

/////////////////////////////////////////
//////// REPORTES de usuarios //////////
///////////////////////////////////////

function reporteUsuarios(){
    let limite = $("#select_limite").val();

    var fd = new FormData();
    fd.append("mode", "getReporteUsuarios");
    fd.append("limite", limite);

    Swal.fire({
        title: "Espere un momento",
        text: "Realizando consulta...",
        confirmButtonColor: $(".btn-primary").css("background-color"),
        confirmButtonText: "Reintentar",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {

                fetch(HOST2, {
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
        didOpen: () => Swal.clickConfirm(), // Hace clic en el botón de confirmación automáticamente al abrir el modal
    }).then((result) => {

        if (result.value) {
            let resp = result.value;

            if(resp.error){
                Swal.fire("Error", resp.mensaje, "error");
            }else{
                let activos = resp.activos[0].cantidad
                let desactivados = resp.desactivados[0].cantidad

                Swal.fire("Reporte de usuarios", `El sistema cuenta con ${activos} usuarios colaborador y ${desactivados} usuario comunes.`, "info");
            }
        }
    });
}

// funcion para imprimir los datos devueltos de la consulta de reporte de usuarios
function imprimirResultadosUsuario(json, textoTh){
    console.log(json);
    // limpiar tabla
    tbodyUsuarios.children().remove();
    
    json.forEach( (usuario,index) => {
        tbodyUsuarios.append(`
        <tr>
            <td> ${index+1} </td>
            <td class="libro_titulo"> ${usuario.nombre +" " + usuario.apellido} </td>
            <td> ${usuario.cedula} </td>
            <td> ${usuario.cantidad} </td>
            <td class="td-actions  text-right">
                <a href="perfil.php?usuario=${usuario.usuario_id}" class="btn-flat btn-accion" title="Ver perfil"  data-toggle="tooltip" data-placement="top">
                <i class="material-icons cyan-text">visibility</i>
                </a>
            </td>
        </tr>
        `);
        $("#thResultadoUsuario").text(textoTh);
    });

    $("#usuarios_resultado").slideDown(600);
    $("#botonesReportesUsuarios").slideUp(600);
    $("#formBuscarLibro").slideUp(600);
}

// boton de volver en los reportes 
function cerrarReportes(){

    // cerrar reporte para libros
    $("#libros_resultado").slideUp(400,function(){
        tbodyLibros.children().remove();
    });
    $("#botonesReportes").slideDown(400);
    $("#formBuscarLibro").slideDown(400);

    // cerrar reporte para usuarios 
    $("#usuarios_resultado").slideUp(400,function(){
        tbodyUsuarios.children().remove();
    });
    $("#botonesReportesUsuarios").slideDown(400);
    $("#formBuscarLibro").slideDown(400);
}