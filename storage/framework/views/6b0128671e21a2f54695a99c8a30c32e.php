<?php $__env->startSection('title'); ?>
    Notes
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded mb-4">
        <h2>Notes</h2>
        <a href="<?php echo e(route('notes.create')); ?>" class="btn btn-primary">Add Note</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($note->title); ?></h5>
                        <p class="card-text"><?php echo e(Str::limit($note->content, 150)); ?></p>
                        <p class="card-text"><strong>Date:</strong> <?php echo e($note->date); ?></p>
                        <p class="card-text"><strong>Time:</strong> <?php echo e($note->time); ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('notes.edit', $note->id)); ?>" class="btn btn-warning">Edit</a>
                            <form action="<?php echo e(route('notes.destroy', $note->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No notes found.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/notes/index.blade.php ENDPATH**/ ?>