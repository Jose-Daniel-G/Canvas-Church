<?php $__env->startSection('title', 'Mis Tareas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tasks"></i> Listado de Tareas
            </h3>
            <div class="card-tools">
                <a href="<?php echo e(route('admin.profesor.tareas.create')); ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Nueva Tarea
                </a>
            </div>
        </div>

        <div class="card-body">
            
            <div class="form-group">
                <label>Filtrar por curso:</label>
                <select id="filtro_curso" class="form-control">
                    <option value="">Todos los cursos</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($curso->id); ?>"><?php echo e($curso->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            
            <table id="tareas-table" class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Curso</th>
                        <th>Título</th>
                        <th>Fecha Entrega</th>
                        <th>Puntaje</th>
                        <th>Entregas</th>
                        <th>Ver</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-curso="<?php echo e($tarea->curso_id); ?>">
                        <td scope="row"><?php echo e($tarea->curso->nombre); ?></td>
                        <td scope="row"><?php echo e($tarea->titulo_tarea); ?></td>
                        <td scope="row"><?php echo e($tarea->fecha_entrega ? $tarea->fecha_entrega->format('d/m/Y') : 'Sin fecha'); ?></td>
                        <td scope="row"><?php echo e($tarea->puntaje); ?></td>
                        <td scope="row"> <span class="badge badge-info"> <?php echo e($tarea->entregas->count()); ?> entregas </span>
                        </td>
                        <td scope="row">
                            <a href="<?php echo e(route('admin.profesor.tareas.show', $tarea->id)); ?>" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td scope="row">
                            <a href="<?php echo e(route('admin.profesor.tareas.edit', $tarea->id)); ?>"
                                class="btn btn-warning btn-sm mr-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.profesor.tareas.destroy')): ?>
                            <form id="delete-form-<?php echo e($tarea->id); ?>"
                                action="<?php echo e(route('admin.profesor.tareas.destroy', $tarea->id)); ?>"
                                method="POST" 
                                style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                    data-id="<?php echo e($tarea->id); ?>"
                                    data-text="¿Estás seguro de eliminar este tarea?">
                                    <i class="fas fa-trash"></i></button>
                            </form>
                            
                            <?php endif; ?>
                        </td>
                    </tr> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        // DataTable
        var table = $('#tareas-table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        // Filtro por curso
        $('#filtro_curso').on('change', function() {
            var cursoId = $(this).val();

            if (cursoId) {
                table.rows().every(function() {
                    var row = this.node();
                    if ($(row).data('curso') == cursoId) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });
            } else {
                table.rows().every(function() {
                    $(this.node()).show();
                });
            }

            table.draw();
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church\resources\views/profesor/tareas/index.blade.php ENDPATH**/ ?>