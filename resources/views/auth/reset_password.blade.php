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
                <form class="m-auto w-75" action="{{ route('change_password') }}" method="POST">
                    @csrf
                    <div class="head_step text-center mb-5">
                        <h2>Reset Password.</h2>
                    </div>
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/pass_ic.svg') }}" alt="">
                        <input type="password" name="password" class="form-control"
                               placeholder="New Password" value="{{ old('email') }}">
                        @include('auth.includes.single_error' , ['name' => 'password'])
                    </div>
                    <div class="form-group">
                        <img class="for_user_img" src="{{ asset('assets/img/pass_ic.svg') }}" alt="">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Confirm Password" value="{{ old('email') }}">
                        @include('auth.includes.single_error' , ['name' => 'password_confirmation'])
                    </div>

                    <div class="form-group">
                        <input type="submit"
                               class="btn btn-primary mb-4 d-flex align-items-center justify-content-center download-btn"
                               value="Change Password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('auth.includes.scripts')
</body>
</html>
