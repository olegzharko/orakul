<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Відновлення пароля</div>
                <div class="card-body">
                    <div class="alert alert-success" role="alert"><?php echo e(__('Користувач '.$user_email.' відправив запит на відновлення пароля.')); ?></div>
                    <a href="<?php echo e(url('password/reset/'.$token)); ?>">Click Here</a>.
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /home/ozharko/synction.space/app/orakul/back/resources/views/auth/password/verify.blade.php ENDPATH**/ ?>