@extends('layouts.app-login')

@section('body')

<div class="container">
    <div class="row">
        <div class="form">
            <div style="display: flex;justify-content: center;align-items: center;">
                <img class="logo" src="{{ asset('images/cs_logo.png') }}" width="350px" alt="AVATAR">
            </div>

            <span class="login100-form-title p-t-30">
                ระบบครุภัณฑ์ สาขาวิชาวิทยาการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น

            </span>
            <label style="display: flex;justify-content: center;align-items: center; color:#ffffff;">
                ------------------------ </label>

            @if (session()->has('message'))
            <div class="alert alert-danger">
                {{ session()->get('message') }}
            </div><br />
            @endif

            <div>
                <form method="POST" class="login100-form validate-form" action="{{ route('login') }}">
                    @csrf

                    <div class="wrap-input100 validate-input m-b-10" data-validate="กรุณากรอกชื่อผู้ใช้งาน">
                        {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                        --}}
                        <input id="user_id" type="text" class="input100" name="user_id" value="{{ old('user_id') }}"
                            placeholder="ชื่อผู้ใช้งาน" required autofocus>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div data-tooltip="นักศึกษา : กรอกรหัสนักศึกษา(มีขีด) บุคลากร : ใช้อีเมล xx@kku.ac.th"
                        class="pagination__dot">
                        <img src='https://image.flaticon.com/icons/svg/1828/1828833.svg'
                            style="float: inherit;position: absolute;" width="21px" height="21px">
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="กรุณากรอกรหัสผ่าน">
                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        --}}
                        <input id="password" type="password" class="input100" name="password" required
                            placeholder="รหัสผ่าน" autocomplete="current-password">

                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                <font color="white">{{ __('Remember Me') }}</font>
                            </label>
                        </div>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button type="submit" class="login100-form-btn">
                            {{ __('Login') }}
                        </button>

                        <div class="text-center w-full p-t-25">
                            <a class="txt1" name="create_user" href="{{ route('register') }}">
                                สมัครสมาชิก
                            </a>
                            <span class="txt2">|</span>
                            <a class="txt1" name="" href="#">
                                คู่มือใช้งาน
                            </a>
                        </div>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>

<script>
    $('#btnresult').on('click', function () {
        console.log("btn click");
        var data = $('#namid').val();

        console.log(data);

        if (auth() - > user() - > user_status == 0) {
            Swal.fire({
                title: 'กรุณารอ การยืนยันการสมัคร จากแอดมิน!!',
                type: 'warning',
                showCloseButton: true
            })

        }
    })

</script>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}
</div>

<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('email') }}</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div> --}}
@endsection
