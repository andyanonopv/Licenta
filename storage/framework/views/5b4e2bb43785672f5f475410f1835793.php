<?php $__env->startSection('title'); ?>
    Projects 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center bg-white mb-4 shadow-sm p-3 rounded">
            <h2>Projects</h2>
            <a href="<?php echo e(route('projects.create')); ?>" class="btn btn-primary">Add Project</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($project->name); ?></h5>
                            <p class="card-text"><?php echo e($project->description); ?></p>
                            <p class="card-text">
                                <strong>Status:</strong> <?php echo e($project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed')); ?><br>
                                <strong>Deadline:</strong> 
                                <?php if($project->end_date && $project->end_date->isFuture()): ?>
                                    <?php echo e($project->end_date->diffForHumans()); ?>

                                <?php else: ?>
                                    <span class="text-danger">Deadline Passed</span>
                                <?php endif; ?>
                            </p>
                            <a href="<?php echo e(route('projects.tasks.index', $project->id)); ?>" class="btn btn-primary"> <i class="bi bi-list"></i> </a>
                            <a href="<?php echo e(route('projects.show', $project->id)); ?>" class="btn btn-primary"> <i class="bi bi-eye"></i> </a>
                            <a href="<?php echo e(route('projects.edit', $project->id)); ?>" class="btn btn-warning"> <i class="bi bi-pencil-square"></i> </a>
                            <form action="<?php echo e(route('projects.destroy', $project->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')"> <i class="bi bi-trash"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/projects/index.blade.php ENDPATH**/ ?>