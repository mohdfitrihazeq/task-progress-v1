@extends('layouts.app')
  
@section('title', 'Create Role')
  
@section('contents')
    <!-- <h1 class="mb-0">Add Role</h1> -->
    <hr />
    <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <!-- <div class="col">
                <input type="text" name="role_name" class="form-control" placeholder="Role">
            </div> -->
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
            <!-- <div class="col">
                <input type="text" name="price" class="form-control" placeholder="Price">
            </div> -->
        </div>
        <!-- <div class="row mb-3">
            <div class="col">
                <input type="text" name="product_code" class="form-control" placeholder="Product Code">
            </div>
            <div class="col">
                <textarea class="form-control" name="description" placeholder="Descriptoin"></textarea>
            </div>
        </div> -->
 
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection