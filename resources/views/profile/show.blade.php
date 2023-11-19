@extends('layouts.app')
  
@section('title', 'Show User')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail project</h1> -->
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $profile->name }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $profile->email }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Role</label>
            <input type="text" name="role_name" class="form-control" placeholder="role" value="{{ $profile->role_name }}" readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
   
@endsection