<div id="modalEditarDatosLibro" class="modal">
    <div class="modal-header">
        <h5 class="valign-wrapper"> <i class="material-icons left">book</i> Datos del libro</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <div class="modal-content">

        <form action="" id="formEditarDatosLibro">
            <div class="row">
                <div class="col s12 input-field" style="margin-bottom:0;">
                    <input type="text" id="editar_titulo" name="modal_e_titulo" required placeholder="null"/>
                    <label for="editar_titulo">título:</label>
                </div>

                <!-- autor -->
                <div class="col s12 input-field" style="margin-top:0;">
                    <label for="">Autores: </label> 
                    <br>
                    <div class="chips" id="editar_chipsAutores"></div>
                </div>

                <div class="col s12 m6 input-field">
                    <select id="editar_editorial" name="modal_e_editorial" required>
                        <option value="" disabled selected></option>
                        <?php
                            foreach ($editoriales as $e) {
                        ?>
                            <option value="<?= $e->id; ?>"> <?= $e->nombre; ?> </option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="editar_editorial">Editorial:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <select id="editar_edicion" name="modal_e_edicion" required>
                        <option value="" disabled selected></option>
                        <option value="Primera edición">Primera edición</option>
                        <option value="Segunda edición">Segunda edición</option>
                        <option value="Tercera edición">Tercera edición</option>
                        <option value="Cuarta edición">Cuarta edición</option>
                        <option value="Quinta edición">Quinta edición</option>
                        <option value="Sexta edición">Sexta edición</option>
                        <option value="Séptima edición">Séptima edición</option>
                        <option value="Octava edición">Octava edición</option>
                        <option value="Novena edición">Novena edición</option>
                        <option value="Décima edición">Décima edición</option>
                    </select>
                    <label for="editar_edicion">Edición:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="date" id="editar_fecha" name="modal_e_fecha"/>
                    <label for="editar_fecha">Fecha:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <select id="editar_carrera" name="modal_e_carrera" required>
                        <option value="" disabled selected></option>
                        <?php
                            foreach ($carreras as $c) {
                        ?>
                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="editar_carrera">Carrera:</label>
                </div>

                <div class="col s12 input-field">
                    <select id="editar_categoria" name="modal_e_categoria" required>
                        <option value="" disabled selected></option>
                        <?php
                            foreach ($categorias as $c) {
                        ?>
                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="editar_categoria">categoría:</label>
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