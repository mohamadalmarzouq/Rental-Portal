<!DOCTYPE html>
<html lang="en" translate="no" class="notranslate">

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
                <form class="m-auto w-75" action="{{ route('login') }}" method="POST">
                    @csrf
                    @include('auth.includes.flash_mesages',['hide_all_errors' => false])

                    <div class="signUpWrp">
                        <p class="mb-0 mr-3">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="mb-0 mr-3">Signing up as a Landlord</a>
                        {{-- <a href="{{ route('register') }}" class="btn sig   nUpBtn">Signing up as a Landlord</a> --}}
                    </div>

                    <div class="head_step text-center mb-5">
                        <h2>Welcome to Landlord Studio.</h2>
                        <p>How real estate gets real</p>
                    </div>
                    <!--<div class="socialBtnWrp mb-4">
                      <a href="#" class="btn btnGoogle mr-4">
                        Sign In With
                        <i class="fa fa-google ml-2"></i>
                      </a>
                      <a href="#" class="btn btnFb ml-4">
                        Sign In With
                        <i class="fa fa-facebook ml-2"></i>
                      </a>
                    </div>-->

                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/user_ic.svg') }}" alt="">
                        <input autocomplete="username" type="email" name="email" class="form-control"
                               placeholder="Email" value="{{ old('email') }}">
                        @include('auth.includes.single_error' , ['name' => 'email'])
                    </div>
                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/pass_ic.svg') }}" alt="">
                        <input autocomplete="current-password" type="password" name="password" class="form-control"
                               placeholder="Password">
                        @include('auth.includes.single_error' , ['name' => 'password'])
                    </div>
                    <div class="form-group">
                        <input type="submit"
                               class="btn btn-primary mb-4 d-flex align-items-center justify-content-center download-btn"
                               value="Login">
                        {{--<a href="index.html" class="btn btn-primary mb-4 d-flex align-items-center justify-content-center">Login</a>--}}
                        <a href="{{ route('forgot_password') }}" class="d-block text-center"><b>Forgot password?</b></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
{{--<div class="container-fluid">
    <div class="row">
        <div class="sign_up w-100 d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="wd-100p">
                                <h3 class="tx-color-01 mg-b-5">Login</h3>
                                <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please Login to continue.</p>

                                <div class="form-group">
                                    <label>Email address</label>
                                    <input autocomplete="username" type="email" name="email" class="form-control"
                                           placeholder="yourname@yourmail.com" value="{{ old('email') }}">
                                    @include('auth.includes.single_error' , ['name' => 'email'])
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mg-b-5">
                                        <label class="mg-b-0-f">Password</label>
                                    </div>
                                    <input autocomplete="current-password" type="password" name="password" class="form-control"
                                           placeholder="Enter your password">
                                    @include('auth.includes.single_error' , ['name' => 'password'])
                                </div>
                                <input type="submit" class="btn btn-brand-02 btn-block" value="Login">
                                <div class="tx-13 mg-t-20 tx-center">Don't have an account?
                                    <a href="{{ route('register') }}">Create an Account</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@include('auth.includes.scripts')
</body>
</html>
