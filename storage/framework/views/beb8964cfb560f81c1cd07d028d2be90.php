<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded mb-4">
            <h2>Upcoming Routines</h2>
            <a href="<?php echo e(route('routines.create')); ?>" class="btn btn-primary">Add Routine</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3>Daily Routines</h3>
                        <div class="kanban-column">
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingDailyRoutines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($routine->title); ?></h5>
                                        <p class="card-text"><?php echo e($routine->description); ?></p>
                                        <p class="card-text"><strong>Days:</strong>
                                            <?php echo e(implode(', ', json_decode($routine->days, true) ?? [])); ?></p>
                                        <p class="card-text"><strong>Time:</strong> <?php echo e($routine->start_time); ?> -
                                            <?php echo e($routine->end_time); ?></p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo e(route('routines.edit', $routine->id)); ?>" class="btn btn-warning"><i
                                                    class="bi bi-pencil"></i></a>
                                            <form action="<?php echo e(route('routines.destroy', $routine->id)); ?>" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this routine?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p>No upcoming daily routines.</p>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="<?php echo e(route('routines.showDaily')); ?>" class="btn btn-secondary">View All Daily
                                    Routines</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3>Weekly Routines</h3>
                        <div class="kanban-column">
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingWeeklyRoutines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($routine->title); ?></h5>
                                        <p class="card-text"><?php echo e($routine->description); ?></p>
                                        <p class="card-text"><strong>Weeks:</strong>
                                            <?php echo e(implode(', ', json_decode($routine->weeks, true) ?? [])); ?></p>
                                        <p class="card-text"><strong>Time:</strong> <?php echo e($routine->start_time); ?> -
                                            <?php echo e($routine->end_time); ?></p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo e(route('routines.edit', $routine->id)); ?>"
                                                class="btn btn-warning">Edit</a>
                                            <form action="<?php echo e(route('routines.destroy', $routine->id)); ?>" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this routine?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p>No upcoming weekly routines.</p>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="<?php echo e(route('routines.showWeekly')); ?>" class="btn btn-secondary">View All Weekly
                                    Routines</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3>Monthly Routines</h3>
                        <div class="kanban-column">
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingMonthlyRoutines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($routine->title); ?></h5>
                                        <p class="card-text"><?php echo e($routine->description); ?></p>
                                        <p class="card-text"><strong>Months:</strong>
                                            <?php echo e(implode(
                                                ', ',
                                                array_map(function ($month) {
                                                    return DateTime::createFromFormat('!m', $month)->format('F');
                                                }, json_decode($routine->months, true) ?? []),
                                            )); ?>

                                        </p>
                                        <p class="card-text"><strong>Time:</strong> <?php echo e($routine->start_time); ?> -
                                            <?php echo e($routine->end_time); ?></p>
                                        <div class="d-flex justify-content-between">
                                            <a href="<?php echo e(route('routines.edit', $routine->id)); ?>"
                                                class="btn btn-warning">Edit</a>
                                            <form action="<?php echo e(route('routines.destroy', $routine->id)); ?>" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this routine?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p>No upcoming monthly routines.</p>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="<?php echo e(route('routines.showMonthly')); ?>" class="btn btn-secondary">View All Monthly
                                    Routines</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/routines/index.blade.php ENDPATH**/ ?>