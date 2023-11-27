@extends('layouts.app')
  
@section('title', 'Show User')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail project</h1> -->
    <hr />
    <div class="row mb-3">
    <div class="col-md-6">
            <label class="form-label">User Login Name</label>
            <input type="text" name="user_name" class="form-control" value="{{$profile->user_name}}" readonly required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Employee Name</label>
            <input type="text" name="name" class="form-control" value="{{$profile->name}}" readonly required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="{{$profile->email}}" readonly required>
        </div>
        <div class="col-md-6">
            <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" required> -->
            <label class="form-label">Role</label>
            <input type="text" name="role_name" class="form-control" value="{{$profile->role_name}}" readonly required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Company</label>
            <input type="text" name="company_name" class="form-control" value="{{$profile->company->company_name}}" readonly required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
   
@endsection