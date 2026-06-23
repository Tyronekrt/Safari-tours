<?php $__env->startSection('title', 'Gallery Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gallery</h1>
        <a href="<?php echo e(route('admin.gallery.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Photo
        </a>
    </div>

    <!-- Gallery Grid -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="<?php echo e(str_starts_with($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image)); ?>" class="card-img-top" alt="<?php echo e($gallery->title); ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($gallery->title); ?></h5>
                        <?php if($gallery->location): ?>
                            <p class="card-text small text-muted"><i class="fas fa-map-marker-alt me-1"></i><?php echo e($gallery->location); ?></p>
                        <?php endif; ?>
                        <?php if($gallery->description): ?>
                            <p class="card-text small"><?php echo e(Str::limit($gallery->description, 80)); ?></p>
                        <?php endif; ?>
                        <div class="mb-2">
                            <?php if($gallery->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="<?php echo e(route('admin.gallery.edit', $gallery)); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="<?php echo e(route('admin.gallery.toggle-active', $gallery)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.gallery.destroy', $gallery)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No gallery photos found. <a href="<?php echo e(route('admin.gallery.create')); ?>" class="alert-link">Add your first photo</a>.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($galleries->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($galleries->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/gallery/index.blade.php ENDPATH**/ ?>