@extends('layouts.app')
  
@section('title', 'Edit User')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit profile</h1> -->
    
    <hr />
    <form action="{{ route('profile.edit', $profile->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
        @if(Auth::user()->role_name == 'Master Super Admin - MSA')
            <div class="col mb-3">
                <label class="form-label">Company</label>
                <!-- <input type="text" name="company_id" class="form-control" placeholder="profile" value="{{ $profile->company_id }}" required> -->
                <select class="form-control" name="role_name" placeholder="Role">
                    @foreach ($companies as $company)
                    <option value="{{ $company->company_id }}" {{ $profile->company_id == $company->company_id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        @endif
            <div class="col mb-3">
                <label class="form-label">User Login Name</label>
                <input type="text" name="user_name" class="form-control" placeholder="profile" value="{{ $profile->user_name }}" readonly required>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Password</label>
                <!-- <input type="password" name="password" id="passwordInput" class="form-control" placeholder="profile" value="{{ $profile->password }}" required> -->
                <input type="password" name="new_password" class="form-control" id="passwordInput" placeholder="Reset Password">
                <small class="form-text text-muted">Leave blank to keep the existing password.</small>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
            <!-- <div class="input-group-append">
                <div class="input-group-text">
                    <input type="checkbox" onclick="togglePassword()"> Show
                </div>
            </div> -->
            <div class="col mb-3">
                <label class="form-label">Employee Name</label>
                <input type="text" name="name" class="form-control" placeholder="profile" value="{{ $profile->name }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="profile" value="{{ $profile->email }}" required>
            </div>
            <div class="col-md-6 col-md-offset-4 mb-3">
                <label class="form-label">Role</label>
                <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" value="{{ $profile->role_name }}" required> -->
                <!-- <label class="labels">Role</label> -->
                <select class="form-control" name="role_name" placeholder="Role">
                    @foreach ($roles as $role)
                        @if(Auth::user()->role_name == 'Master Super Admin - MSA' || $role->role_name != 'Master Super Admin - MSA')
                        <option value="{{ $role->role_name }}" {{ $profile->role_name == $role->role_name ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById('passwordInput');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
@endsection