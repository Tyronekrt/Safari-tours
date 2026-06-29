<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Management</h1>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New User
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.users.index')); ?>">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') == $role->name ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($role->name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Enquiries</th>
                            <th>Assigned</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($user->id); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($user->avatar): ?>
                                            <img src="<?php echo e($user->avatar); ?>" class="rounded-circle me-2" alt="<?php echo e($user->name); ?>" style="width: 40px; height: 40px;">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white small"><?php echo e(substr($user->name, 0, 1)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?php echo e($user->name); ?></strong>
                                            <p class="mb-0 small text-muted"><?php echo e($user->email); ?></p>
                                            <p class="mb-0 small text-muted"><?php echo e($user->phone); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-primary"><?php echo e(ucfirst($role->name)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php if($user->is_active): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->enquiries->count()); ?></td>
                                <td><?php echo e($user->assignedEnquiries->count()); ?></td>
                                <td><?php echo e($user->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.toggle-status', $user->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-<?php echo e($user->is_active ? 'danger' : 'success'); ?>">
                                            <i class="fas fa-<?php echo e($user->is_active ? 'ban' : 'check'); ?>"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" style="display: inline;" data-delete-form data-confirm-message="Are you sure you want to delete this user?">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/users/index.blade.php ENDPATH**/ ?>