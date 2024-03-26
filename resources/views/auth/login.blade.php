<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <title>Form Login </title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>

<body class="light">
    <!-- Pre loader -->
    <div id="loader" class="loader">
        <div class="plane-container">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="app">
        <div class="page parallel">
            <div class="d-flex row">
                <div class="col-md-3 white">
                    <div class="pl-5 pt-5 pr-5 mt-5 pb-0">
                        <img src="" alt="" />
                    </div>
                    <div class="p-5">
                        <h3>Selamat Datang</h3>
                        <p>Silahkan masukkan username dan password Anda.</p>
                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf
                            <div class="form-group has-icon"><i class="icon-user"></i>
                                <input type="text" class="form-control form-control-lg  @if ($errors->has('username')) is-invalid @endif" placeholder="Username" name="username" autocomplete="off" value="{{ old('username') }}" required autofocus>
                                @if ($errors->has('username'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group has-icon"><i class="icon-user-secret"></i>
                                <input type="password" class="form-control form-control-lg @if ($errors->has('password')) is-invalid @endif" placeholder="Password" name="password" autocomplete="off" value="{{ old('password') }}" required>
                                @if ($errors->has('password'))
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                                @endif

                            </div>
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Log In">

                            {{-- <p> Belum punya akun? Silahkan <a href="{{ route('register')}}">Daftar.</a> <br>
                            <a href="{{ route('password.request')}}">Lupa Password? </a>
                            </p> --}}

                        </form>
                    </div>
                </div>
                <div class="col-md-9  height-full blue accent-3 align-self-center text-center" data-bg-repeat="false" data-bg-possition="center" style="background: url('img/icon/icon-plane.png') #FFEFE4">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var APP_URL = {
            !!json_encode(url('/').
                '/') !!
        }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>