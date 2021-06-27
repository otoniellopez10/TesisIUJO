<div id="modalCambiarClave" class="modal">
    <div class="modal-header">
        <h5 class="valign-wrapper"> <i class="material-icons left">password</i>Cambiar contraseña</h5>
        <i class="material-icons modal-close">close</i>
    </div>
    <form action="" id="formCambiarClave">
        <div class="modal-content">

            <div class="row">
                <div class="col s12 input-field">
                    <input type="password" id="i_actual" name="i_actual" required placeholder="Ingresa tu contraseña actual"/>
                    <label for="i_actual">Contraseña actual:</label>
                </div>

                <div class="col  m6 input-field">
                    <input type="password" id="i_nueva" name="i_nueva" required placeholder="Ingresa tu nueva contraseña"/>
                    <label for="i_nueva">Nueva contraseña:</label>
                </div>

                <div class="col s12 m6 input-field">
                    <input type="password" id="i_nuevaRepeat" name="i_nuevaRepeat" required placeholder="Repite la nueva contraseña"/>
                    <label for="i_nuevaRepeat">Repetir contraseña:</label>
                </div>
            </div>
        </div>
    
        <div class="modal-footer row">
            <div class="col s12">
                <a class="btn-flat waves-effect waves-light modal-close">Cerrar</a>
                <button type="submit" class="btn waves-effect waves-light">Guardar Cambios</button>
            </div>
        </div>
    </form>

</div>