<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Safari Tour Management'); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920');
            background-size: cover;
            background-position: center;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .package-card {
            transition: transform 0.3s;
        }
        .package-card:hover {
            transform: translateY(-5px);
        }
        .status-new { background-color: #17a2b8; }
        .status-contacted { background-color: #ffc107; }
        .status-quotation_sent { background-color: #6f42c1; }
        .status-negotiation { background-color: #fd7e14; }
        .status-confirmed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
                <?php echo $__env->make('components.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('packages.index')); ?>">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('gallery.index')); ?>">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('about')); ?>">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('contact')); ?>">Contact</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->hasRole('customer')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('enquiry.create')); ?>">Submit Enquiry</a>
                    </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <?php echo e(auth()->user()->name); ?>

                            </a>
                            <ul class="dropdown-menu">
                                <?php if(auth()->user()->hasRole('customer')): ?>
                                    <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">My Dashboard</a></li>
                                <?php endif; ?>
                                <?php if(auth()->user()->hasRole(['super_admin', 'admin', 'sales_agent'])): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Admin Panel</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <?php echo $__env->make('components.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <p>Your trusted partner for unforgettable safari experiences in Africa.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-white">Home</a></li>
                        <li><a href="<?php echo e(route('packages.index')); ?>" class="text-white">Packages</a></li>
                        <li><a href="<?php echo e(route('gallery.index')); ?>" class="text-white">Gallery</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="text-white">About Us</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p><i class="fas fa-envelope me-2"></i>info@safaritours.com</p>
                    <p><i class="fas fa-phone me-2"></i>+254 700 000 000</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Nairobi, Kenya</p>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="text-center">
                <p>&copy; 2024 Safari Tours. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php if(session('success')): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.toast').remove();
            }, 3000);
        </script>
    <?php endif; ?>
</body>
</html><?php /**PATH /home/kelvin/Projects/Safari/resources/views/layouts/app.blade.php ENDPATH**/ ?>