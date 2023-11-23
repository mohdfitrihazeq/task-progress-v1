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
                <select class="form-control" name="role_name" placeholder="Role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->role_name }}">{{ $role->role_name }}</option>
                    @endforeach
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