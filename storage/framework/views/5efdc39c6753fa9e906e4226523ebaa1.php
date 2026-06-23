<?php $__env->startSection('title', 'Enquiries Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Enquiries</h1>
        <a href="<?php echo e(route('admin.enquiries.index')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-filter me-1"></i> Clear Filters
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.enquiries.index')); ?>">
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
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Assigned To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">All Agents</option>
                            <?php $__currentLoopData = $salesAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($agent->id); ?>" <?php echo e(request('assigned_to') == $agent->id ? 'selected' : ''); ?>>
                                    <?php echo e($agent->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Enquiries Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Travel Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($enquiry->id); ?></td>
                                <td>
                                    <strong><?php echo e($enquiry->full_name); ?></strong>
                                    <p class="mb-0 small text-muted"><?php echo e($enquiry->email); ?></p>
                                    <p class="mb-0 small text-muted"><?php echo e($enquiry->phone); ?></p>
                                </td>
                                <td>
                                    <?php if($enquiry->package): ?>
                                        <?php echo e($enquiry->package->title); ?>

                                    <?php else: ?>
                                        <span class="text-muted">No package</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge status-<?php echo e($enquiry->status); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $enquiry->status))); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($enquiry->assignedTo): ?>
                                        <?php echo e($enquiry->assignedTo->name); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.enquiries.show', $enquiry->id)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No enquiries found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($enquiries->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($enquiries->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/enquiries/index.blade.php ENDPATH**/ ?>