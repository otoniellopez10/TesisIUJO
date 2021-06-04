<div id="modalEditarDatosLibro" class="modal">
    <div class="modal-header">
        <h5 class="valign-wrapper"> <i class="material-icons left">book</i> Datos del libro</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <div class="modal-content">

        <form action="" id="formEditarDatosLibro">
            <div class="row">
                <div class="col s12 input-field">
                    <input type="text" id="editar_titulo" name="modal_e_titulo" required placeholder="null"/>
                    <label for="editar_titulo">título:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="editar_editorial" name="modal_e_editorial" required placeholder="null"/>
                    <label for="editar_editorial">Editorial:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="editar_edicion" name="modal_e_edicion" required placeholder="null"/>
                    <label for="editar_edicion">Edición:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="date" id="editar_fecha" name="modal_e_fecha"/>
                    <label for="editar_fecha">Fecha:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="editar_carrera" name="modal_e_carrera" required placeholder="null"/>
                    <label for="editar_carrera">Carrera:</label>
                </div>

                <div class="col s12 input-field">
                    <input type="text" id="editar_categoria" name="modal_e_categoria" required placeholder="null"/>
                    <label for="editar_categoria">Categoría:</label>
                </div>
                
                <!-- <div class="col s12 input-field hide">
                    <input type="text" id="editar_autores" name="modal_e_autores" required placeholder="null"/>
                    <label for="editar_autores">autores:</label>
                </div> -->

                <div class="col s12 input-field">
                    <textarea name="modal_e_resumen" id="editar_resumen" class="materialize-textarea" required placeholder="null"></textarea>
                    <label for="editar_resumen">Resumen:</label>
                </div>
                <div class="col s12 right-align">
                    <a class="btn-flat waves-effect waves-light modal-close">Cerrar</a>
                    <button type="submit" class="btn waves-effect waves-light">Guardar Cambios</button>
                </div>

            </div>
        </form>

    </div>

    <div class="modal-footer row">
    </div>
</div>