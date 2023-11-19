@extends('layouts.app')
  
@section('contents')
    <h1 class="mb-0">Profile</h1>
    <hr />
 
    <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('profile') }}" >
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row" id="res"></div>
                <div class="row mt-2">
  
                    <div class="col-md-6">
                        <label class="labels">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="first name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Email</label>
                        <input type="text" name="email" disabled class="form-control" value="{{ auth()->user()->email }}" placeholder="Email">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ auth()->user()->phone }}">
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}" placeholder="Address">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Role</label>
                        <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" value="{{ auth()->user()->role_name }}"> -->
                            <select id="role_name" class="form-control" role_name="name" value="{{ auth()->user()->role_name }}" required autofocus>
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
                </div>
                <br>
                <div class="form-group">
                    <div class="mt-5 text-center">
                        <button id="btn" class="btn btn-primary profile-button" type="submit">Save Profile</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
         
    </div>   
            
        </form>
@endsection