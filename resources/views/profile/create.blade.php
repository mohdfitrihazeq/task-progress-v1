@extends('layouts.app')
  
@section('title', 'Create User')
  
@section('contents')
    <!-- <h1 class="mb-0">Add project</h1> -->
    <hr />
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col">
                <input type="text" name="email" class="form-control" placeholder="Email" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <select class="form-control" name="role_name">
                    <option value="MSA">Master Super Admin</option>
                    <option value="AC">Account</option>
                    <option value="Admin">Administrator</option>
                    <option value="CM">Contract Manager</option>
                    <option value="PD">Project Director</option>
                    <option value="PM">Project Manager</option>
                    <option value="PURC">Purchaser</option>
                    <option value="QS">Quality Surveyor</option>
                    <option value="SA">Super Admin</option>
                    <option value="Site">Site</option>
                    <option value="SSA">Super Super Admin</option>
                    <option value="VIEW">Viewing</option>
                </select>
            </div>
            <div class="col">
            <input name="password" type="password" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Password" required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection