<?php

include_once '../mc-models/Rol.php';
$objRol = new Rol();
$roles = $objRol->getAll();

?>
<div id="modalEditarRol" class="modal">
    <div class="modal-header blue darken-1">
        <h5 class="valign-wrapper"> <i class="material-icons left">person_pin</i>Editar rol del usuario</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <div class="modal-content">

        <form action="" id="formEditarRol">
            <div class="row">

                <div class="col s12 input-field">
                    <input type="text" id="EditarRolNombre" disabled required placeholder="null"/>
                    <label for="EditarRolNombre">Nombre y apellido:</label>
                </div>

                <div class="col s12 input-field">
                    <select id="editarRolSelect" name="editarRolSelect" required>
                        <option value="" disabled>-- Seleccione un rol --</option>
                        <?php foreach ($roles as $r) { ?>
                        <option value='<?= $r->id ?>'>
                        <?= $r->nombre ?>
                        </option>
                        <?php } ?>
                    </select>
                    <label>Editar rol:</label>
                </div>
                <div class="col s12 right-align" style="margin: 50px 0 10px 0;">
                    <button type="button" class="btn-flat waves-effect waves-light modal-close">Cerrar</button>
                    <button type="submit" class="btn waves-effect waves-light" id="btnCambiarRol">Guardar Cambios</button>
                </div>
            </div>
        </form>

    </div>

    <!-- <div class="modal-footer row">
    </div> -->
</div>