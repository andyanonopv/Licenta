<?php $__env->startSection('title'); ?>
    <?php echo e($project->name); ?> - Project Details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white text-center"> <?php echo e($project->name); ?></h2>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($project->name); ?></h5>
                        <p class="card-text"><?php echo e($project->description); ?></p>
                        <p class="card-text"><strong>Start Date:</strong>
                            <?php echo e(\Carbon\Carbon::parse($project->start_date)->format('Y-m-d')); ?></p>
                        <p class="card-text"><strong>End Date:</strong>
                            <?php echo e(\Carbon\Carbon::parse($project->end_date)->format('Y-m-d')); ?></p>
                        <p class="card-text"><strong>Status:</strong>
                            <?php echo e($project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed')); ?>

                        </p>
                        <p class="card-text"><strong>Budget:</strong> $<?php echo e($project->budget); ?></p>

                        <h5 class="mt-4">Project Progress</h5>
                        <?php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'completed')->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        ?>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo e($progress); ?>%;"
                                aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo e(round($progress)); ?>%</div>
                        </div>

                        <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-secondary mt-3">Back to Projects</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title"> Team Members </h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addMemberModal"> <i class="bi bi-plus-circle"></i> </button>
                        </div>

                        <div class="row">
                            <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <p class="card-title fw-bolder"><?php echo e($user->name); ?></p>
                                                    <p class="card-text"><?php echo e($user->email); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('projects.addMember')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label>
                            <select class="form-select" name="user_id" id="">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bodo\Downloads\Licenta - Final Project\task-manager-test\Task-Manager\resources\views/projects/show.blade.php ENDPATH**/ ?>