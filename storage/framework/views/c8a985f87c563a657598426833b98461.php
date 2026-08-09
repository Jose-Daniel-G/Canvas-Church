<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Listado de Roles Editar </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para actualizar roles -->
                <form id="editForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <p class="h5">Nombre Completo:</p>
                    <input type="text" id="edit-name" class="form-control" name="name">
                    <p class="h5">Apellido:</p>
                    <input type="text" id="edit-apellido" class="form-control" name="apellido">
                    <p class="h5">Email:</p>
                    <input type="text" id="edit-email" class="form-control" name="email">

                    <p class="h5 mt-3">Cambiar contraseña <small class="text-muted">(opcional, dejar en blanco para no cambiarla)</small></p>
                    <input type="password" id="edit-password" class="form-control mb-2" name="password" placeholder="Nueva contraseña" autocomplete="new-password">
                    <input type="password" id="edit-password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirmar nueva contraseña" autocomplete="new-password">

                    <p class="h5 mt-3">Roles</p>
                    <div id="rolesContainer"></div>

                    
                    <button type="submit" class="btn btn-primary mt-3">Asignar rol</button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>