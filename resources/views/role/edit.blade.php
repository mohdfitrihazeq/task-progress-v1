@extends('layouts.app')
  
@section('title', 'Edit role')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit role</h1> -->
    
    <hr />
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Role</label>
                <input type="text" name="role_name" class="form-control" placeholder="Role" value="{{ $role->role_name }}" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('roles') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection