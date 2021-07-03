<?php $__env->startSection('content'); ?>

<?php echo $__env->make('nova::auth.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<form
    class="bg-white shadow rounded-lg p-8 max-w-login mx-auto"
    method="POST"
    action="<?php echo e(route('nova.password.email')); ?>"
>
    <?php echo e(csrf_field()); ?>


    <?php $__env->startComponent('nova::auth.partials.heading'); ?>
        <?php echo e(__('Forgot your password?')); ?>

    <?php if (isset($__componentOriginal02ff6066a846884865ea5d72d8659d4fcf8ad130)): ?>
<?php $component = $__componentOriginal02ff6066a846884865ea5d72d8659d4fcf8ad130; ?>
<?php unset($__componentOriginal02ff6066a846884865ea5d72d8659d4fcf8ad130); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

    <?php if(session('status')): ?>
    <div class="text-success text-center font-semibold my-3">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>

    <?php echo $__env->make('nova::auth.partials.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-6 <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
        <label class="block font-bold mb-2" for="email"><?php echo e(__('Email Address')); ?></label>
        <input class="form-control form-input form-input-bordered w-full" id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>
    </div>

    <button class="w-full btn btn-default btn-primary hover:bg-primary-dark" type="submit">
        <?php echo e(__('Send Password Reset Link')); ?>

    </button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('nova::auth.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ozharko/synction.space/app/orakul/back/nova/src/../resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>