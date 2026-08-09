<?php $__env->startSection('title', 'Roles'); ?>

<?php $__env->startSection('content_header'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal88b0e6813f5b80100a19437aa80e29ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88b0e6813f5b80100a19437aa80e29ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88b0e6813f5b80100a19437aa80e29ba)): ?>
<?php $attributes = $__attributesOriginal88b0e6813f5b80100a19437aa80e29ba; ?>
<?php unset($__attributesOriginal88b0e6813f5b80100a19437aa80e29ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88b0e6813f5b80100a19437aa80e29ba)): ?>
<?php $component = $__componentOriginal88b0e6813f5b80100a19437aa80e29ba; ?>
<?php unset($__componentOriginal88b0e6813f5b80100a19437aa80e29ba); ?>
<?php endif; ?>

    <div class="card-body">
        <div class="card card-outline card-primary">

            <div class="card-header">
                    <h1 class="card-title" style="font-weight: bold;">Roles</h1>

                <div class="card-tools">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.create')): ?>
                        <a class="btn btn-secondary" data-toggle="modal" data-target="#createModal">Registrar
                            <i class="bi bi-plus-circle-fill"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="roles" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Permisos</th>
                                <th>Creación</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($role->id); ?></td>
                                    <td><?php echo e($role->name); ?></td>
                                    <td><?php echo e($role->permissions->pluck('name')->implode(', ')); ?></td>
                                    <td><?php echo e($role->created_at->format('d M, Y')); ?></td>
                                    <td class="d-flex justify-content-center">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
                                            
                                            <a href="#" class="btn btn-warning btn-sm mr-1" data-id="<?php echo e($role->id); ?>"
                                                data-toggle="modal" data-target="#editModal" title="Editar"> <i
                                                    class="fas fa-edit"></i></a>
                                        <?php endif; ?>

                                        
                                        <form id="delete-form-<?php echo e($role->id); ?>"
                                            action="<?php echo e(route('admin.roles.destroy', $role->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="btn btn-danger btn-delete"
                                                    data-id="<?php echo e($role->id); ?>"
                                                    data-text="¿Estás seguro de que deseas eliminar este rol?">
                                                    <i class="fas fa-trash"></i>
                                        </form>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay roles disponibles.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo $__env->make('admin.roles.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('admin.roles.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        new DataTable('#roles', {
            responsive: true,
            scrollX: true,
            autoWidth: false,
            dom: 'Bfrtip', // Añade el contenedor de botones
                buttons: [{extend: 'copyHtml5',text: '<i class="bi bi-clipboard-check"></i> Copiar',className: 'btn btn-sm btn-success'}, // Added btn-sm for better consistency
                          {extend: 'csvHtml5',text: '<i class="bi bi-filetype-csv"></i> CSV',className: 'btn btn-sm btn-warning'},
                          {extend: 'excelHtml5',text: '<i class="bi bi-file-earmark-excel"></i> Excel',className: 'btn btn-sm btn-secondary'},
                          {extend: 'pdfHtml5',text: '<i class="bi bi-filetype-pdf"></i> PDF',className: 'btn btn-sm btn-danger'},
                          {extend: 'print',text: '<i class="bi bi-printer"></i> Imprimir',className: 'btn btn-sm btn-dark' },
                          {extend: 'colvis'}],
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ cursos",
                "infoEmpty": "Mostrando 0 a 0 de 0 cursos",
                "infoFiltered": "(filtrado de _MAX_ cursos totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ cursos",
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
            var id = button.data('id');
            var modal = $(this);

            var url = "<?php echo e(route('admin.roles.edit', ':id')); ?>".replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    var formAction = "<?php echo e(route('admin.roles.update', ':id')); ?>".replace(':id', data.role.id);
                    modal.find('#editForm').attr('action', formAction);
                    modal.find('#edit-name').val(data.role.name);

                    var container = modal.find('#rolesContainer');
                    container.empty();

                    // row declarado una sola vez
                    var row = $('<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2"></div>');

                    // Si hasPermissions son ids (recomendado)
                    // convertir a strings para evitar problemas de tipo si lo deseas:
                    var hasPerms = data.hasPermissions.map(String);

                    data.permissions.forEach(function(permission) {
                        var checked = hasPerms.includes(String(permission.id)) ? 'checked' : '';
                        var html = `
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="permission[]"
                                value="${permission.name}" id="permission_${permission.id}" ${checked}>
                            <label class="form-check-label" for="permission_${permission.id}">
                                ${permission.name}
                            </label>
                        </div>
                    </div>
                `;
                        row.append(html);
                    });

                    container.append(row);
                },
                error: function(xhr) {
                    console.error('Error al cargar los datos del rol:', xhr);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church5\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>