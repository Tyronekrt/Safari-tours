<?php $__env->startSection('title', 'Testimonials Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Testimonials</h1>
        <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Testimonial
        </a>
    </div>

    <!-- Testimonials Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Content</th>
                            <th>Rating</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($testimonial->id); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($testimonial->customer_image): ?>
                                            <img src="<?php echo e(asset('storage/' . $testimonial->customer_image)); ?>" class="rounded-circle me-2" alt="<?php echo e($testimonial->customer_name); ?>" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php endif; ?>
                                        <strong><?php echo e($testimonial->customer_name); ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 small"><?php echo e(Str::limit($testimonial->content, 80)); ?></p>
                                </td>
                                <td>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $testimonial->rating): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-muted"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </td>
                                <td>
                                    <?php if($testimonial->package_name): ?>
                                        <?php echo e($testimonial->package_name); ?>

                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($testimonial->is_approved): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Pending</span>
                                    <?php endif; ?>
                                    <?php if($testimonial->is_featured): ?>
                                        <span class="badge bg-warning">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo e(route('admin.testimonials.edit', $testimonial)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.testimonials.toggle-approved', $testimonial)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.testimonials.toggle-featured', $testimonial)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.testimonials.destroy', $testimonial)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center">No testimonials found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($testimonials->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($testimonials->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/testimonials/index.blade.php ENDPATH**/ ?>