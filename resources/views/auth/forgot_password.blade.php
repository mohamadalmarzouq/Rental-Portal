<!DOCTYPE html>
<html lang="en">

@include('auth.includes.head')
<body>
<section class="loginWrap bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="bg_img" style="background-image: url('{{ asset('assets/img/login_bg.png')}}')">

                </div>
            </div>
            <div class="col-md-6 d-flex">
                <form class="m-auto w-75" action="{{ route('forgot_password') }}" method="POST">
                    @csrf
                    @include('auth.includes.flash_mesages',['hide_all_errors' => false])

                    <div class="signUpWrp">
                        <p class="mb-0 mr-3">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="btn signUpBtn">Sign Up</a>
                    </div>

                    <div class="head_step text-center mb-5">
                        <h2>Forgot Password.</h2>
                        <p>Enter your email for forgot password</p>
                    </div>

                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/user_ic.svg') }}" alt="">
                        <input autocomplete="username" type="email" name="email" class="form-control"
                               placeholder="Email" value="{{ old('email') }}">
                        @include('auth.includes.single_error' , ['name' => 'email'])
                    </div>

                    <div class="form-group">
                        <input type="submit"
                               class="btn btn-primary mb-4 d-flex align-items-center justify-content-center download-btn"
                               value="Send Mail">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('auth.includes.scripts')
</body>
</html>
