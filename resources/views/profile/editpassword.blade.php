@extends('layouts.app')
  
@section('title', 'Change Password')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit profile</h1> -->
    
    <hr />
    <script src="{{asset('admin_assets/js/firstlogin.js')}}"></script>
    <form action="{{ route('profile.updatepassword', $profile->id) }}" method="POST" class="user">
      @csrf
      @method('PUT')
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
@endsection