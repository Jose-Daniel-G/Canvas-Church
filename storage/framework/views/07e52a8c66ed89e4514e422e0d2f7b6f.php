<!-- Modal de Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
               <h5 class="modal-title" id="createModalLabel">Crear <?php echo e(__('Role')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body"> 

                <form action="<?php echo e(route('admin.roles.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3 row align-items-end">
                        <div class="col">
                            <label for="name" class="form-label">Nombre</label>
                            <input value="<?php echo e(old('name')); ?>" type="text" placeholder="Ingresa el nombre"
                                name="name" id="name" class="form-control">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enviar
                            </button>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="form-check">
                                    <input type="checkbox" name="permission[]"
                                        id="permission-<?php echo e($permission->id); ?>"
                                        class="form-check-input"
                                        value="<?php echo e($permission->name); ?>">
                                    <label class="form-check-label" for="permission-<?php echo e($permission->id); ?>">
                                        <?php echo e($permission->name); ?>

                                    </label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\jjdd1\Downloads\Canvas-Church5\resources\views/admin/roles/create.blade.php ENDPATH**/ ?>