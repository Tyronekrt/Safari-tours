<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="mb-4">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4"><?php echo e($totalUsers); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Enquiries</h5>
                    <p class="card-text display-4"><?php echo e($totalEnquiries); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">New Enquiries</h5>
                    <p class="card-text display-4"><?php echo e($newEnquiries); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Confirmed</h5>
                    <p class="card-text display-4"><?php echo e($confirmedBookings); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enquiry Status Distribution -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Enquiry Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['new'] / $totalEnquiries * 100) : 0); ?>%">
                            New: <?php echo e($enquiriesByStatus['new']); ?>

                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['contacted'] / $totalEnquiries * 100) : 0); ?>%">
                            Contacted: <?php echo e($enquiriesByStatus['contacted']); ?>

                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['quotation_sent'] / $totalEnquiries * 100) : 0); ?>%; background-color: #6f42c1;">
                            Quotation Sent: <?php echo e($enquiriesByStatus['quotation_sent']); ?>

                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-orange" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['negotiation'] / $totalEnquiries * 100) : 0); ?>%; background-color: #fd7e14;">
                            Negotiation: <?php echo e($enquiriesByStatus['negotiation']); ?>

                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['confirmed'] / $totalEnquiries * 100) : 0); ?>%">
                            Confirmed: <?php echo e($enquiriesByStatus['confirmed']); ?>

                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo e($totalEnquiries > 0 ? ($enquiriesByStatus['cancelled'] / $totalEnquiries * 100) : 0); ?>%">
                            Cancelled: <?php echo e($enquiriesByStatus['cancelled']); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Conversion Rate</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h1 class="display-1 fw-bold"><?php echo e(number_format($conversionRate, 1)); ?>%</h1>
                        <p class="text-muted">Confirmed bookings out of total enquiries</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Enquiries -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Enquiries</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentEnquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($enquiry->full_name); ?></strong>
                                        <p class="mb-0 small text-muted"><?php echo e($enquiry->email); ?></p>
                                    </div>
                                    <span class="badge status-<?php echo e($enquiry->status); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $enquiry->status))); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($user->name); ?></strong>
                                        <p class="mb-0 small text-muted"><?php echo e($user->email); ?></p>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo e($user->roles->pluck('name')->first() ?? 'Customer'); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>