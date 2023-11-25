<script src="{{asset('admin_assets/js/firstlogin.js')}}"></script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Task Progress - First Login</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">System Login</h1>
              </div>
              <form action="{{ route('changepassword') }}" method="POST" class="user">
                @csrf
                <div class="form-group">
                    <input name="user_name" hidden value="{{$user}}" id="exampleInputUsername">{{$user}}
                  @error('user_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input name="password" type="password" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                    @error('password')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation')is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
                    @error('password_confirmation')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="show_password" name="show_password" onclick="showPassword() ">
                        <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                    </svg>
                    Show Password
                </div>
                <div class="form-group">
                    The password should at least be a mix of a lower case ( e.g. a, d), upper case 
                    character (e.g. B, F),  number (e.g. 2, 3) and symbol (e.g. &, @)
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Change Password</button>
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
</body>
</html>