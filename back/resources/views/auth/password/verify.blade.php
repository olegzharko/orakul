<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Відновлення пароля</div>
                <div class="card-body">
                    <div class="alert alert-success" role="alert">{{ __('Користувач '.$user_email.' відправив запит на відновлення пароля.') }}</div>
                    <a href="{{ url('password/reset/'.$token) }}">Click Here</a>.
                </div>
            </div>
        </div>
    </div>
</div>

