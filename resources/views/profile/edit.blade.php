@extends('layouts.app')
  
@section('title', 'Edit Profile')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit profile</h1> -->
    
    <hr />
    <form action="{{ route('profile.update', $profile->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="profile" value="{{ $profile->name }}" required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="profile" value="{{ $profile->email }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-4 mb-3">
                <label class="form-label">Role</label>
                <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" value="{{ $profile->role_name }}" required> -->
                <!-- <label class="labels">Role</label> -->
                <select class="form-control" name="role_name" value="{{ $profile->role_name }}">
                    <option value="MSA" @if($profile->role_name == 'MSA') selected @endif>Master Super Admin</option>
                    <option value="AC" @if($profile->role_name == 'AC') selected @endif>Account</option>
                    <option value="Admin" @if($profile->role_name == 'Admin') selected @endif>Administrator</option>
                    <option value="CM" @if($profile->role_name == 'CM') selected @endif>Contract Manager</option>
                    <option value="PD" @if($profile->role_name == 'PD') selected @endif>Profile Director</option>
                    <option value="PM" @if($profile->role_name == 'PM') selected @endif>Profile Manager</option>
                    <option value="PURC" @if($profile->role_name == 'PURC') selected @endif>Purchaser</option>
                    <option value="QS" @if($profile->role_name == 'QS') selected @endif>Quality Surveyor</option>
                    <option value="SA" @if($profile->role_name == 'SA') selected @endif>Super Admin</option>
                    <option value="Site" @if($profile->role_name == 'Site') selected @endif>Site</option>
                    <option value="SSA" @if($profile->role_name == 'SSA') selected @endif>Super Super Admin</option>
                    <option value="VIEW" @if($profile->role_name == 'VIEW') selected @endif>Viewing</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection