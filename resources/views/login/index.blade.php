<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-login.css') }}">
    <title>Login</title>
</head>

<body>
    <div class="container tengah">
        <div class="row justify-content-center">

            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-md-5 d-none d-md-block bagian-kiri m-auto">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="LOGO" class="img" width="100"
                            height="100">
                        <h5>PT Wellracom Industri Komputindo</h5>
                        <p>Login Page</p>
                        <div class="sponsor">
                        </div>
                    </div>
                    <div class="col-md-7 bagian-kanan">
                        <h2>MDA System</h2>
                        <p>Machine Data Acquisition</p>
                        <div class="register-form">
                            <form action="" method="post">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control"
                                        placeholder="Email or username" value="{{ old('username') }}">
                                    @error('username')
                                        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="password">
                                    @error('password')
                                        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" value="1"
                                            id="remember" name="remember">
                                        <label class="custom-control-label" for="remember">Remember
                                            Me</label>
                                    </div>
                                </div>

                                <button type="submit" name="submit" id="submit" class="btn btn-dark">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
