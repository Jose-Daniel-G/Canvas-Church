<?php $__env->startSection('title', ucfirst(auth()->user()->getRoleNames()->first())); ?>
<?php $__env->startSection('css'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/items.css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($esProfesor): ?>
        <div class="row pt-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo e($misCursos->count()); ?></h3>
                        <p>Mis cursos</p>
                    </div>
                    <div class="icon"><i class="fas fa-book"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo e($totalMisEstudiantes); ?></h3>
                        <p>Estudiantes a cargo</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo e($entregasPendientes); ?></h3>
                        <p>Entregas por calificar</p>
                    </div>
                    <div class="icon"><i class="fas fa-file-signature"></i></div>
                    <a href="<?php echo e(route('admin.profesor.tareas.index')); ?>" class="small-box-footer">Ver tareas <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?php echo e($proximasClases->count()); ?></h3>
                        <p>Próximas clases</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mis próximas clases</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $proximasClases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($clase->curso->nombre ?? 'N/A'); ?></td>
                                        <td><?php echo e($clase->fecha_hora_inicio->format('d M, Y')); ?></td>
                                        <td><?php echo e($clase->fecha_hora_inicio->format('H:i')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No tiene clases próximas
                                            programadas.</td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Mis cursos</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $misCursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($curso->nombre); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center text-muted">Aún no tiene cursos asignados.</td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="row pt-3">
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.config.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo e($total_configuraciones); ?></h3>
                        <p>Configuracion</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <a href="<?php echo e(route('admin.config.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.secretarias.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo e($total_secretarias); ?></h3>
                        <p>Programador</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <a href="<?php echo e(route('admin.secretarias.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.estudiantes.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo e($total_estudiantes); ?></h3>
                        <p>Estudiantes</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users mr-2"></i>
                    </div>
                    <a href="<?php echo e(route('admin.estudiantes.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.cursos.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo e($total_cursos); ?></h3>
                        <p>Cursos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="<?php echo e(route('admin.cursos.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.estudiantes.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo e($total_profesores); ?></h3>
                        <p>Profesores</p>
                    </div>
                    <div class="icon"><i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <a href="<?php echo e(route('admin.profesores.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.horarios.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?php echo e($total_horarios); ?></h3>

                        <p>Horarios</p>
                        
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <a href="<?php echo e(route('admin.horarios.index')); ?>" class="small-box-footer">Mas info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.reservas.index')): ?>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?php echo e($total_agendas); ?></h3>

                        <p>Reservas</p>
                    </div>
                    <div class="icon">
                        <i class="ion fas bi bi-calendar2-week"></i>
                    </div>
                    <a href="" class="small-box-footer"> <i class="fas fa-calendar-alt"></i></a>
                </div>
            </div>
        <?php endif; ?>

        
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    
                        <h4>Progreso</h4>
                        <h5 class="mb-2">(Cursos)</h5>
                        <br> 
                    

                </div>
                <div class="icon"> <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i
                        class="fas fa-arrow-circle-right"></i></a>
                
            </div>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->hasRole('pruebas')): ?>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <!-- ROMBO -->
                    <div class="shape-item shape-sm">
                        <div class="diamond badge-shape">
                            <span class="diamond-text"><i class="far fa-star"></i></span>
                        </div>
                    </div>
                    <div class="info-box-content"> Insign Rombo</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <div class="shape-item shape-sm">
                        <div class="octagon badge-shape">
                            <span class="octagon-text">Oct</span>
                        </div>
                    </div>
                    <div class="shape-label">Octagono</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="info-box">
                    <div class="shape-item shape-sm">
                        <div class="shield badge-shape">
                            <span class="shield-text">Escudo</span>
                        </div>
                    </div>
                    <div class="shape-label">Escudo</div>
                </div>
            </div>
            
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    </div>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::check() && Auth::user()->hasRole('pruebas')): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="card-title">Calendario de reservas</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php echo e(Auth::user()->profesor->nombres); ?>

                        <table id="reservas" class="table table-striped table-bordered table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nro</th>
                                    <th>Profesor</th>
                                    <th>Estudiante</th>
                                    <th>Fecha de la reserva</th>
                                    <th>Hora de reserva</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(Auth::user()->profesor->id == $clase->profesor_id): ?>
                                        <tr>
                                            <td scope="row"><?php echo e($contador++); ?></td>
                                            <td scope="row">
                                                <?php echo e($clase->profesor->nombres . ' ' . $clase->profesor->apellidos); ?>

                                            </td>
                                            <td scope="row">
                                                <?php echo e($clase->estudiante->nombres . ' ' . $clase->estudiante->apellidos); ?>

                                            </td>
                                            <td scope="row" class="text-center">
                                                <?php echo e($clase->start->format('d M, Y')); ?></td>
                                            <td scope="row" class="text-center">
                                                <?php echo e($clase->end->format('H:i')); ?></td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script>
    window.Laravel = {
        isEstudiante: <?php echo json_encode(Auth::check() && Auth::user()->estudiante !== null, 15, 512) ?>,
        routes: {
            horariosShowReservaProfesores: "<?php echo e(route('admin.horarios.show_reserva_profesores')); ?>",
        }
    };
</script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/pages/dashboard.ts']); ?>
    <script>
        // ---------------------------------------
        // Cargar contenido dinámico en selects
        // ---------------------------------------
        $('#profesor_select').on('change', function() {
            const curso_id = $(this).val();
            console.log(curso_id);
            const url = "<?php echo e(route('admin.horarios.show_datos_cursos', ':id')); ?>".replace(':id', curso_id);
            if (!curso_id) {
                $('#curso_info').html('');
                return;
            }
            $.get(url, function(data) {
                $('#curso_info').html(data);
            }).fail(() => alert('Error al obtener datos del curso'));
        });

        $('#cursoid').on('change', function() {
            const cursoid = $(this).val();
            if (!cursoid) return;
            const url = "<?php echo e(route('admin.obtenerProfesores', ':id')); ?>".replace(':id', cursoid);
            $.get(url, function(data) {
                if (Array.isArray(data)) {
                    $('#profesorid').empty().append(
                        '<option value="" selected disabled>Seleccione un Profesor</option>');
                    data.forEach(p => $('#profesorid').append(
                        `<option value="${p.id}">${p.nombres} ${p.apellidos}</option>`));
                } else {
                    alert('No se encontraron profesores');
                }
            }).fail(() => alert('Error al cargar los profesores'));
        });

        $('#estudiante_id').on('change', function() {
            const estudiante_id = $(this).val();
            if (!estudiante_id) return;
            const url = "<?php echo e(route('admin.obtenerCursos', ':id')); ?>".replace(':id', estudiante_id);
            $.get(url, function(data) {
                if (Array.isArray(data)) {
                    $('#cursoid').empty().append(
                        '<option value="" selected disabled>Seleccione un Curso</option>');
                    data.forEach(c => $('#cursoid').append(`<option value="${c.id}">${c.nombre}</option>`));
                } else {
                    alert('No se encontraron cursos');
                }
            }).fail(() => alert('Error al cargar los cursos'));
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church5\resources\views/admin/index.blade.php ENDPATH**/ ?>