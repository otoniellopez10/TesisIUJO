<?php

include_once '../mc-models/Rol.php';
$objRol = new Rol();
$roles = $objRol->getAll();

?>
<div id="modalEditarRol" class="modal">
    <div class="modal-header teal">
        <h5 class="valign-wrapper"> <i class="material-icons left">person_pin</i>Editar rol del usuario</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <div class="modal-content">

        <form action="" id="formEditarRol">
            <div class="row">

                <div class="col s12 m6 valign-wrapper">
                    <b class="teal-text">Nombre y apellido: &nbsp</b>
                    <p id="EditarRolNombre"></p>
                </div>

                <div class="col s12 m6 valign-wrapper">
                    <b class="teal-text">Cédula: &nbsp</b>
                    <p id="EditarRolCedula"></p>
                </div>
                <div class="col s12" style="margin-bottom: 25px;"></div>
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