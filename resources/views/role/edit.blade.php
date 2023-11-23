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
                <!-- <select class="form-control" name="role_name" value="{{ $role->role_name }}">
                    <option value="MSA" @if($role->role_name == 'MSA') selected @endif>Master Super Admin</option>
                    <option value="AC" @if($role->role_name == 'AC') selected @endif>Account</option>
                    <option value="Admin" @if($role->role_name == 'Admin') selected @endif>Administrator</option>
                    <option value="CM" @if($role->role_name == 'CM') selected @endif>Contract Manager</option>
                    <option value="PD" @if($role->role_name == 'PD') selected @endif>Profile Director</option>
                    <option value="PM" @if($role->role_name == 'PM') selected @endif>Profile Manager</option>
                    <option value="PURC" @if($role->role_name == 'PURC') selected @endif>Purchaser</option>
                    <option value="QS" @if($role->role_name == 'QS') selected @endif>Quality Surveyor</option>
                    <option value="SA" @if($role->role_name == 'SA') selected @endif>Super Admin</option>
                    <option value="Site" @if($role->role_name == 'Site') selected @endif>Site</option>
                    <option value="SSA" @if($role->role_name == 'SSA') selected @endif>Super Super Admin</option>
                    <option value="VIEW" @if($role->role_name == 'VIEW') selected @endif>Viewing</option>
                </select> -->
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