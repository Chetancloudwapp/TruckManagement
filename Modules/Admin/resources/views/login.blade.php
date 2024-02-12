<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Truck Management </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/adminlte.min2167.css?v=3.2.0')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}" />
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center"> <a style="font-weight: 600; font-size: 26px;" href="{{ url('admin/login')}}" class="h1"><img src="{{ asset('public/assets/images/truck.jpg')}}" width="15%" >
               <strong>Truck Management</strong>
            </a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <form action="{{ url('admin/login')}}" method="post">
                    @csrf
                    <div class="input-group mb-3"> 
                        <input type="email" class="form-control" name="email"  @if(isset($_COOKIE['email'])) value="{{ $_COOKIE['email']}}" @endif placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"> <span class="fas fa-envelope"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3"> 
                        <input type="password" name="password" class="form-control"  @if(isset($_COOKIE['password'])) value="{{ $_COOKIE['password']}}" @endif placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"> <span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="icheck-primary">
                          <input type="checkbox" id="remember" name="remember" @if(isset($_COOKIE["email"])) checked="" @endif>
                          <label for="remember">
                            Remember Me
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button> </div>
                    </form>
                    <h6 class="forgot_sec"> <a href="">Forgot Password?</a> </h6>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/adminlte.min2167.js?v=3.2.0')}}"></script>
</body>
</html>

{{-- $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); --}}