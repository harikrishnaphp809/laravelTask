<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body class="vertical-layout vertical-menu-modern" data-open="click" data-menu="vertical-menu-modern" data-col="" data-framework="laravel">
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <?php if(\Session::get('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <?php echo e(\Session::get('success')); ?>

                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <?php echo e(\Session::forget('success')); ?>

            <?php if(\Session::get('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <?php echo e(\Session::get('error')); ?>

                </div>
                <button type="button" id="closebutton" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <div class="card mb-0">
                <div class="card-body">
                    <h2 class="brand-text text-primary ms-1">Admin Login</h2>

                    <form class="auth-login-form mt-2" action="<?php echo e(route('adminLoginPost')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mb-1">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo e(old('username')); ?>" autofocus />
                            <?php if($errors->has('username')): ?>
                            <span class="help-block font-red-mint">
                                <strong><?php echo e($errors->first('username')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-1">
                            <!-- <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                <a href="<?php echo e(url('auth/forgot-password-basic')); ?>">
                                    <small>Forgot Password?</small>
                                </a>
                            </div> -->
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                            <?php if($errors->has('password')): ?>
                            <span class="help-block font-red-mint">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="4">Submit</button>
                    </form>
                </div>
            </div>
            <!-- /Login basic -->
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\laravelTask\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>