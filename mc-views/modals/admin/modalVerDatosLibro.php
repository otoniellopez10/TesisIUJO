<div id="modalVerDatosLibro" class="modal">
    <div class="modal-header">
        <h5 class="valign-wrapper"> <i class="material-icons left">book</i> Datos del libro</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <div class="modal-content">

        <form action="" id="formVerDatosLibro">
            <div class="row">
                <div class="col s12 input-field">
                    <input type="text" id="modal_i_titulo" name="modal_titulo" disabled  required placeholder="null"/>
                    <label for="modal_i_titulo">título:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="modal_i_editorial" name="modal_editorial" disabled  required placeholder="null"/>
                    <label for="modal_i_editorial">Editorial:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="modal_i_edicion" name="modal_edicion" disabled  required placeholder="null"/>
                    <label for="modal_i_edicion">Edición:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="modal_i_fecha" name="modal_fecha" disabled  required placeholder="null"/>
                    <label for="modal_i_fecha">Fecha:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="text" id="modal_i_carrera" name="modal_carrera" disabled  required placeholder="null"/>
                    <label for="modal_i_carrera">Carrera:</label>
                </div>

                <div class="col s12 input-field">
                    <input type="text" id="modal_i_categoria" name="modal_categoria" disabled  required placeholder="null"/>
                    <label for="modal_i_categoria">Categoría:</label>
                </div>
                
                <div class="col s12 input-field">
                    <input type="text" id="modal_i_autores" name="modal_autores" disabled  required placeholder="null"/>
                    <label for="modal_i_autores">autores:</label>
                </div>

                <div class="col s12 input-field">
                    <textarea name="modal_resumen" id="modal_i_resumen" class="disabled materialize-textarea" disabled required placeholder="null"></textarea>
                    <label for="modal_i_resumen">Resumen:</label>
                </div>

            </div>
        </form>

    </div>

    <div class="modal-footer row">
        <div class="col s12">
            <button class="btn-flat waves-effect waves-light modal-close">Cerrar</button>
        </div>
    </div>
</div>