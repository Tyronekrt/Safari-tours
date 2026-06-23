<?php $__env->startSection('title', 'Contacts Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contacts</h1>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.contacts.index')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $status))); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, subject" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary w-100">Clear Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($contact->read_at ? '' : 'table-primary'); ?>">
                                <td>#<?php echo e($contact->id); ?></td>
                                <td>
                                    <strong><?php echo e($contact->name); ?></strong>
                                    <?php if($contact->phone): ?>
                                        <p class="mb-0 small text-muted"><?php echo e($contact->phone); ?></p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($contact->email); ?></td>
                                <td><?php echo e(Str::limit($contact->subject, 30)); ?></td>
                                <td>
                                    <span class="badge status-<?php echo e($contact->status); ?>">
                                        <?php echo e(ucfirst($contact->status)); ?>

                                    </span>
                                    <?php if(!$contact->read_at): ?>
                                        <span class="badge bg-danger">New</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($contact->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.contacts.show', $contact->id)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                                <td colspan="7" class="text-center">No contacts found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($contacts->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($contacts->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/contacts/index.blade.php ENDPATH**/ ?>