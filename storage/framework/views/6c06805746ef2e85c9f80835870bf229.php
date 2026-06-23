<?php $__env->startSection('title', 'Contact Us'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h1 class="display-4 fw-bold">Contact Us</h1>
                <p class="lead">Get in touch with our team for personalized safari planning</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Send Us a Message</h3>
                        
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('contact.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" value="<?php echo e(old('subject')); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="4" required><?php echo e(old('message')); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Contact Information</h3>
                        <div class="mb-4">
                            <i class="fas fa-map-marker-alt fa-lg me-3 text-primary"></i>
                            <strong>Address</strong>
                            <p class="mb-0">Nairobi, Kenya</p>
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-envelope fa-lg me-3 text-primary"></i>
                            <strong>Email</strong>
                            <p class="mb-0">info@safaritours.com</p>
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-phone fa-lg me-3 text-primary"></i>
                            <strong>Phone</strong>
                            <p class="mb-0">+254 700 000 000</p>
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-clock fa-lg me-3 text-primary"></i>
                            <strong>Business Hours</strong>
                            <p class="mb-0">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Follow Us</h3>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-primary btn-lg"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-info btn-lg"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-danger btn-lg"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-danger btn-lg"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/contact.blade.php ENDPATH**/ ?>