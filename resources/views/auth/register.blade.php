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
                <form class="m-auto w-75" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="signUpWrp">
                        <p class="mb-0 mr-3">Already have an account?</p>
                        <a href="{{ route('login') }}" class="btn signUpBtn">Login</a>
                    </div>

                    <div class="head_step text-center mb-5">
                        <h2>Create New Account</h2>
                        <p>It's free to signup and only takes a minute.</p>
                    </div>
{{--                    <div class="socialBtnWrp mb-4">--}}
{{--                      <a href="#" class="btn btnGoogle mr-4">--}}
{{--                        Sign In With--}}
{{--                        <i class="ion-logo-google ml-2"></i>--}}
{{--                      </a>--}}
{{--                      <a href="#" class="btn btnFb ml-4">--}}
{{--                        Sign In With--}}
{{--                        <i class="ion-logo-facebook ml-2"></i>--}}
{{--                      </a>--}}
{{--                    </div>--}}

                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/user_ic.svg') }}" alt="">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                        @include('auth.includes.single_error' , ['name' => 'name'])
                    </div>
                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/user_ic.svg') }}" alt="">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        @include('auth.includes.single_error' , ['name' => 'email'])
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary d-flex align-items-center justify-content-center download-btn" value="Create Account">
                    </div>
                    @include('auth.includes.flash_mesages',['hide_all_errors' => false])
                </form>
            </div>
        </div>
    </div>
</section>
{{--<div class="container-fluid">
    <div class="row">
        <div class="sign_up w-100 d-flex align-items-center">
            <div class="container">
                @include('auth.includes.flash_mesages',['hide_all_errors' => false])
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <img class="w-100" src="{{ asset('assets/img/img16.png') }}" alt="">
                    </div>
                    <div class="col-sm-6">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="pd-t-20 wd-100p">
                                <h4 class="tx-color-01 mg-b-5">Create New Account</h4>
                                <p class="tx-color-03 tx-16 mg-b-40">It's free to signup and only takes a minute.</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter your mame" value="{{ old('name') }}">
                                            @include('auth.includes.single_error' , ['name' => 'name'])
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" name="email" class="form-control"
                                                   placeholder="Enter your email address" value="{{ old('email') }}">
                                            @include('auth.includes.single_error' , ['name' => 'email'])
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group tx-12">
                                    By clicking <strong>Create an account</strong> below, you agree to our terms of
                                    service and privacy statement.
                                </div><!-- form-group -->

                                <input type="submit" class="btn btn-brand-02 btn-block" value="Create Account">
                                <div class="tx-13 mg-t-20 tx-center">Already have an account? <a
                                        href="{{ route('login') }}">Login</a></div>
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
