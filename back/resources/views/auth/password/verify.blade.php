<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Your Email Address</div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Користувач '.$user_email.' відправив запит на відновлення пароля.') }}
                        </div>
                    @endif
                    <a href="{{ url('api/password/reset/'.$token) }}">Click Here</a>.
                </div>
            </div>
        </div>
    </div>
</div>

