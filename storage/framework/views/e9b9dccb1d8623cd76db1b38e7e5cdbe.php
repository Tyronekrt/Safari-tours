<?php $__env->startSection('title', $package->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <!-- Package Hero -->
                <?php if($package->featured_image): ?>
                    <img src="<?php echo e(asset('storage/' . $package->featured_image)); ?>" class="img-fluid rounded mb-4" alt="<?php echo e($package->title); ?>">
                <?php endif; ?>

                <h1 class="display-4 fw-bold mb-3"><?php echo e($package->title); ?></h1>
                
                <div class="mb-4">
                    <?php if($package->duration): ?>
                        <span class="badge bg-info me-2"><i class="fas fa-clock me-1"></i><?php echo e($package->duration); ?> Days</span>
                    <?php endif; ?>
                    <?php if($package->price): ?>
                        <span class="badge bg-success me-2">$<?php echo e(number_format($package->price, 2)); ?></span>
                    <?php endif; ?>
                    <?php if($package->location): ?>
                        <span class="badge bg-secondary me-2"><i class="fas fa-map-marker-alt me-1"></i><?php echo e($package->location); ?></span>
                    <?php endif; ?>
                </div>

                <?php if($package->full_desc): ?>
                    <div class="mb-4">
                        <h3>Description</h3>
                        <p><?php echo $package->full_desc; ?></p>
                    </div>
                <?php endif; ?>

                <?php if($package->highlights && count($package->highlights)): ?>
                    <div class="mb-4">
                        <h3>Highlights</h3>
                        <ul>
                            <?php $__currentLoopData = $package->highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($highlight); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if($package->inclusions && count($package->inclusions)): ?>
                    <div class="mb-4">
                        <h3>Inclusions</h3>
                        <ul>
                            <?php $__currentLoopData = $package->inclusions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inclusion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($inclusion); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Enquiry Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Book This Safari</h3>
                        <form action="<?php echo e(route('enquiry.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Adults</label>
                                    <input type="number" name="adults" class="form-control" value="1" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Children</label>
                                    <input type="number" name="children" class="form-control" value="0" min="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Travel Date</label>
                                <input type="date" name="travel_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Enquiry</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Package Details</h5>
                        <ul class="list-unstyled">
                            <?php if($package->duration): ?>
                                <li class="mb-2"><i class="fas fa-clock me-2"></i><?php echo e($package->duration); ?> Days</li>
                            <?php endif; ?>
                            <?php if($package->price): ?>
                                <li class="mb-2"><i class="fas fa-dollar-sign me-2"></i>$<?php echo e(number_format($package->price, 2)); ?></li>
                            <?php endif; ?>
                            <?php if($package->location): ?>
                                <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i><?php echo e($package->location); ?></li>
                            <?php endif; ?>
                            <?php if($package->category): ?>
                                <li class="mb-2"><i class="fas fa-folder me-2"></i><?php echo e($package->category->name); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <?php if($relatedPackages->count() > 0): ?>
                    <div class="card">
                        <div class="card-body">
                            <h5>Related Packages</h5>
                            <?php $__currentLoopData = $relatedPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3">
                                    <a href="<?php echo e(route('packages.show', $related->slug)); ?>">
                                        <?php echo e($related->title); ?>

                                    </a>
                                    <?php if($related->price): ?>
                                        <span class="badge bg-success">$<?php echo e(number_format($related->price, 2)); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/packages/show.blade.php ENDPATH**/ ?>