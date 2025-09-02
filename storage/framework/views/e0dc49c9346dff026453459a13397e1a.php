<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded mb-4">
        <h2>Uploaded Files</h2>
        <a href="<?php echo e(route('files.create')); ?>" class="btn btn-primary">Upload File</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($file->name); ?></h5>
                        <p class="card-text"><strong>Type:</strong> <?php echo e($file->type); ?></p>
                        <a href="<?php echo e(Storage::url($file->path)); ?>" target="_blank" class="btn btn-primary"> <i class="bi bi-download"></i> </a>
                        <a href="<?php echo e(route('files.edit', $file->id)); ?>" class="btn btn-warning"> <i class="bi bi-pencil-square"></i> </a>
                        <form action="<?php echo e(route('files.destroy', $file->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger"> <i class="bi bi-trash"></i> </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/files/index.blade.php ENDPATH**/ ?>