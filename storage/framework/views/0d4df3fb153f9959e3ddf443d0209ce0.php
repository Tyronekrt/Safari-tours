<?php $__env->startSection('title', 'Safari Packages'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="display-4 fw-bold">Safari Packages</h1>
                <p class="lead">Discover our carefully curated safari experiences</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('packages.index')); ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="category" class="form-select">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Grid -->
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4 mb-4">
                    <div class="card package-card h-100">
                        <?php if($package->featured_image): ?>
                            <img src="<?php echo e(asset('storage/' . $package->featured_image)); ?>" class="card-img-top" alt="<?php echo e($package->title); ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-white">No Image</span>
                            </div>
                        <?php endif; ?>
                        <?php if($package->is_featured): ?>
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">Featured</span>
                        <?php endif; ?>
                        <div class="card-body">
                            <?php if($package->category): ?>
                                <span class="badge bg-info mb-2"><?php echo e($package->category->name); ?></span>
                            <?php endif; ?>
                            <h5 class="card-title"><?php echo e($package->title); ?></h5>
                            <p class="card-text text-muted small"><?php echo e(Str::limit($package->short_desc, 100)); ?></p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <?php if($package->duration): ?>
                                    <span class="badge bg-info"><i class="fas fa-clock me-1"></i><?php echo e($package->duration); ?> Days</span>
                                <?php endif; ?>
                                <?php if($package->price): ?>
                                    <span class="badge bg-success">$<?php echo e(number_format($package->price, 2)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="<?php echo e(route('packages.show', $package->slug)); ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No packages found</h4>
                        <p>Check back later for new safari packages.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($packages->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($packages->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/packages/index.blade.php ENDPATH**/ ?>