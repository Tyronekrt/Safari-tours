<?php $__env->startSection('title', 'Photo Gallery'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Photo Gallery</h1>
            <p class="lead text-muted">Explore the breathtaking scenery and wildlife of Africa</p>
        </div>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo e(str_starts_with($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image)); ?>" class="card-img-top" alt="<?php echo e($gallery->title); ?>" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($gallery->title); ?></h5>
                            <?php if($gallery->location): ?>
                                <p class="card-text text-muted"><i class="fas fa-map-marker-alt me-1"></i><?php echo e($gallery->location); ?></p>
                            <?php endif; ?>
                            <?php if($gallery->description): ?>
                                <p class="card-text"><?php echo e(Str::limit($gallery->description, 100)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No photos available yet</h4>
                        <p>Check back soon for amazing safari photos!</p>
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
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/gallery/index.blade.php ENDPATH**/ ?>