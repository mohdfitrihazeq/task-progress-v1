<script src="{{asset('admin_assets/js/firstlogin.js')}}"></script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TMS</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-primary">
  <div class="bg-secondary px-5 p-2">
    <div class="text-white">
      TMS
    </div>
  </div>
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-white mb-4">System Login</h1>
              </div>
              <form action="{{ route('changepassword') }}" method="POST" class="user">
                @csrf
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                  </div>
                @endif
                <div class="row pb-4 justify-content-center">
                  <div class="col-lg-3">
                    <div class="text-white">
                        User Login Name: 
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="text-white align-middle">
                      <input name="user_name" hidden value="{{$user}}" id="exampleInputUsername">{{$user}}
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <div class="text-white">
                      New Password: 
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input name="password" type="password" class="form-control" id="exampleInputPassword">
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <div class="text-white">
                      Confirm Password: 
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input name="password_confirmation" type="password" class="form-control" id="exampleInputConfirmPassword">
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <div class="text-right text-white form-group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="show_password" name="show_password" onclick="showPassword() ">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                        </svg>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="text-left text-white">
                      Show Password 
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center pb-3">
                  <div class="text-white col-lg-8">
                    The password should at least be a mix of a lower case ( e.g. a, d), upper case 
                    character (e.g. B, F),  number (e.g. 2, 3) and symbol (e.g. &, @)
                  </div>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <button type="submit" class="btn btn-secondary btn-block">Login</button>
                  </div>
                </div>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>
  <div class="fixed-bottom bg-info p-2">
    <div class="text-white text-center">
      © Powered By Tribit
    </div>
  </div>
</body>
</html>