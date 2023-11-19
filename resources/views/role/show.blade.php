@extends('layouts.app')
  
@section('title', 'Show role')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail role</h1> -->
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Role</label>
            <input type="text" name="title" class="form-control" placeholder="Role" value="{{ $role->role_name }}" readonly>
        </div>
        <!-- <div class="col mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $role->price }}" readonly>
        </div> -->
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{ route('roles') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col mb-3">
            <label class="form-label">role_code</label>
            <input type="text" name="role_code" class="form-control" placeholder="role Code" value="{{ $role->role_code }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Descriptoin" readonly>{{ $role->description }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $role->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $role->updated_at }}" readonly>
        </div>
    </div> -->
@endsection