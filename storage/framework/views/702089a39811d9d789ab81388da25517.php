<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Welcome to your Dashboard</h2>
        <p>This is your dashboard where you can manage your tasks, routines, notes, and files.</p>
        
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tasks</h5>
                        <p class="card-text flex-grow-1">You have <strong><?php echo e($tasksCount); ?></strong> tasks pending.</p>
                        <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-primary mt-auto">View Tasks</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Routines</h5>
                        <p class="card-text flex-grow-1">You have <strong><?php echo e($routinesCount); ?></strong> routines scheduled today.</p>
                        <a href="<?php echo e(route('routines.index')); ?>" class="btn btn-primary mt-auto">View Routines</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Notes</h5>
                        <p class="card-text flex-grow-1">You have <strong><?php echo e($notesCount); ?></strong> notes saved.</p>
                        <a href="<?php echo e(route('notes.index')); ?>" class="btn btn-primary mt-auto">View Notes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Files</h5>
                        <p class="card-text flex-grow-1">You have <strong><?php echo e($filesCount); ?></strong> files.</p>
                        <a href="<?php echo e(route('files.index')); ?>" class="btn btn-primary mt-auto">View Files</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Recent Tasks</h5>
                        <ul class="list-group flex-grow-1">
                            <?php $__currentLoopData = $recentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($task->title); ?>

                                    <span class="badge bg-primary rounded-pill"><?php echo e($task->status == 'to_do' ? 'To Do' : 'In Progress'); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Today's Routines</h5>
                        <ul class="list-group flex-grow-1">
                            <?php $__currentLoopData = $todayRoutines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($routine->title); ?>

                                    <span class="badge bg-primary rounded-pill"><?php echo e($routine->frequency); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Recent Notes</h5>
                        <ul class="list-group flex-grow-1">
                            <?php $__currentLoopData = $recentNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($note->title); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Upcoming Reminders</h5>
                        <ul class="list-group flex-grow-1">
                            <?php $__currentLoopData = $upcomingReminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center <?php echo e($reminder->date->isToday() ? 'bg-warning' : ($reminder->date->isPast() ? 'bg-danger' : 'bg-success')); ?>">
                                    <?php echo e($reminder->title); ?>

                                    <span class="badge bg-primary rounded-pill"><?php echo e($reminder->date->format('M d')); ?> <?php echo e($reminder->time ? $reminder->time->format('H:i') : ''); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/dashboard.blade.php ENDPATH**/ ?>