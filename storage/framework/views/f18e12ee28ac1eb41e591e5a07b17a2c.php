<?php $__env->startSection('title', 'JDeveloper'); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap4.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content_header'); ?>
    <h1>Lista de usuarios</h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Usuarios registrados</h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->hasRole('root')): ?>
                <div class="card-tools">
                    <a class="btn btn-secondary" data-toggle="modal" data-target="#createModal">Registrar<i
                            class="bi bi-plus-circle-fill"></i></a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="card-body">
            <table id="usuarios" class="table table-striped table-bordered table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th class="text-center"> Acciones </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->id); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td class="text-center">
                                
                                <a href="#" class="btn btn-warning btn-sm mr-1" data-id="<?php echo e($user->id); ?>"
                                    data-toggle="modal" data-target="#editModal" title="Editar"> <i
                                        class="fas fa-edit"></i></a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permissions.delete')): ?>
                                    <form action="<?php echo e(route('admin.users.toggleStatus', $user->id)); ?>" method="POST"
                                        style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?> <!-- Laravel permite cambios parciales con PATCH -->
                                        <button type="submit" class="btn <?php echo e($user->status ? 'btn-danger' : 'btn-success'); ?>">
                                            <?php echo $user->status ? '<i class="fa-solid fa-circle-xmark"></i>' : '<i class="fa-solid fa-square-check"></i>'; ?>

                                        </button>
                                    </form>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay permisos registrados.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </tbody>
            </table>
            <?php echo $__env->make('admin.users.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.users.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        new DataTable('#usuarios', {
            responsive: true,
            scrollX: true,
            autoWidth: false, //no le vi la funcionalidad
            dom: 'Bfrtip', // Añade el contenedor de botones
            buttons: [{
                    extend: 'copyHtml5',
                    text: '<i class="bi bi-clipboard-check"></i> Copiar',
                    className: 'btn btn-sm btn-success'
                }, // Added btn-sm for better consistency
                {
                    extend: 'csvHtml5',
                    text: '<i class="bi bi-filetype-csv"></i> CSV',
                    className: 'btn btn-sm btn-warning'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-sm btn-secondary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi bi-filetype-pdf"></i> PDF',
                    className: 'btn btn-sm btn-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-sm btn-dark'
                },
                {
                    extend: 'colvis'
                }
            ],
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "orderable": "Ordenar por esta columna",
                    "orderableReverse": "Invertir el orden de esta columna"
                }
            }
        });
    </script>
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var modal = $(this);

            var url = "<?php echo e(route('admin.users.edit', ':id')); ?>".replace(':id', userId);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // Set the form's action URL dynamically
                    var formAction = "<?php echo e(route('admin.users.update', ':id')); ?>".replace(':id', data.user
                        .id);
                    modal.find('#editForm').attr('action', formAction);

                    // Populate the user's name, apellido and email
                    modal.find('#edit-name').val(data.user.name);
                    modal.find('#edit-apellido').val(data.user.apellido);
                    modal.find('#edit-email').val(data.user.email);

                    // La contraseña nunca se precarga; se limpia en cada apertura del modal
                    modal.find('#edit-password').val('');
                    modal.find('#edit-password_confirmation').val('');

                    // Get the container for roles and clear it
                    var rolesContainer = modal.find('#rolesContainer');
                    rolesContainer.empty();

                    // Loop through all available roles and create checkboxes
                    data.roles.forEach(function(role) {
                        // Check if the user has this role
                        var isChecked = data.user.roles.some(userRole => userRole.id === role
                            .id) ? 'checked' : '';

                        // Create the HTML for the checkbox using a template literal
                        var html = `
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="roles[]"
                                value="${role.id}" id="role_${role.id}" ${isChecked}>
                            <label class="form-check-label" for="role_${role.id}">
                                ${role.name}
                            </label>
                        </div>
                    `;
                        rolesContainer.append(html);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching user data:", error);
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church5\resources\views/admin/users/index.blade.php ENDPATH**/ ?>