<div id="modalCalificarLibro" class="modal">
    <div class="modal-header teal">
        <h5 class="valign-wrapper"> <i class="material-icons left">star</i>¿Cuál es tu opinión sobre este libro?</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <form action="" id="formCalificarLibro">
        <div class="modal-content">

            <div class="row">

                <div class="col s12 input-field center-align estrellas">
                    <p id="estrella1" valor="1"><i class="material-icons medium yellow-text">star_border</i></p>
                    <p id="estrella2" valor="2"><i class="material-icons medium yellow-text">star_border</i></p>
                    <p id="estrella3" valor="3"><i class="material-icons medium yellow-text">star_border</i></p>
                    <p id="estrella4" valor="4"><i class="material-icons medium yellow-text">star_border</i></p>
                    <p id="estrella5" valor="5"><i class="material-icons medium yellow-text">star_border</i></p>
                </div>
                <input type="text" name="numeroEstrellas" class="hide" id="i_numeroEstrellas" required>
                
                <div class="col s12 input-field">
                    <textarea name="modalCalificarComentario" id="modalCalificarComentario" class="materialize-textarea" required></textarea>
                    <label for="modalCalificarComentario">Escribe un comentario: </label>
                </div>
                
            </div>
            
        </div>
        
        <div class="modal-footer row">
            <div class="col s12">
                <button class="btn-flat waves-effect waves-light modal-close">Cerrar</button>
                <button class="btn waves-effect waves-light" id="btnModalPublicar">Publicar</button>
            </div>
        </div>
    </form>

</div>