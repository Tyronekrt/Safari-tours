<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - Safari Tours</title>
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-pending { background-color: #ffc107; color: #000; }
        .status-new { background-color: #0d6efd; color: #fff; }
        .status-contacted { background-color: #17a2b8; color: #fff; }
        .status-qualified { background-color: #6610f2; color: #fff; }
        .status-proposal_sent { background-color: #fd7e14; color: #fff; }
        .status-negotiating { background-color: #e83e8c; color: #fff; }
        .status-confirmed { background-color: #198754; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
        .status-closed { background-color: #6c757d; color: #fff; }
        .status-read { background-color: #6c757d; color: #fff; }
        .status-replied { background-color: #198754; color: #fff; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('admin.dashboard')); ?>">
                <?php echo $__env->make('components.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <span class="ms-2">Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                    </li>
                    <?php if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.users.agents')); ?>">Agents</a>
                    </li>
                    <?php endif; ?>
                    <?php if(auth()->user()->hasRole('sales_agent')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.agent.dashboard')); ?>">My Enquiries</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.packages.index')); ?>">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.gallery.index')); ?>">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.testimonials.index')); ?>">Testimonials</a>
                    </li>
                    <?php if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.enquiries.index')); ?>">All Enquiries</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('admin.contacts.index')); ?>">Contacts</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo e(auth()->user()->name); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</html><?php /**PATH /home/kelvin/Projects/Safari/resources/views/layouts/admin.blade.php ENDPATH**/ ?>