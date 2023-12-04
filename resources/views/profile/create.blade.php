@extends('layouts.app')
  
@section('title', 'Create User')
  
@section('contents')
    <!-- <h1 class="mb-0">Add project</h1> -->
    <hr />
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">User Login Name</label>
                <input type="text" name="user_name" class="form-control" placeholder="User Name" value="{{ old('user_name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Employee Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6" id="roleSelect">
                <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" required> -->
                <label class="form-label">Role</label>
                <select class="form-control" name="role_name" placeholder="Role" id="role_name">
                    @foreach ($roles as $role)
                        @if(Auth::user()->role_name == 'Master Super Admin - MSA' || $role->role_name != 'Master Super Admin - MSA')
                        <option value="{{ $role->role_name }}" {{ old('role_name') == $role->role_name ? 'selected' : '' }}>{{ $role->role_name }}</option>
                        @endif
                    @endforeach
                </select>

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input name="password" type="password" id="passwordInput" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Password" value="tmS@1234">
                <input type="checkbox" onclick="togglePassword()"> Show Password
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            @if(Auth::user()->role_name == 'Master Super Admin - MSA')
                <div class="col-md-6" id="companyField">
                    <label class="form-label">Company</label>
                    <select class="form-control" name="company_id" placeholder="Company" id="company_id" required>
                        <option value="" disabled selected>Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->company_id }}" data-original-text="{{ $company->company_name }}" {{ old('company_id') == $company->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>

<script>
    function togglePassword() {
        var passwordInput = document.getElementById('passwordInput');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initial setup
        updateCompanyDropdown();

        // Event listener for role change
        document.getElementById('role_name').addEventListener('change', function () {
            updateCompanyDropdown();
        });

        // Function to update company dropdown based on role
        function updateCompanyDropdown() {
            var roleSelect = document.getElementById('role_name');
            var companyDropdown = document.getElementById('company_id');
            var companyOptions = companyDropdown.options;

            if (roleSelect.value === 'Master Super Admin - MSA') {
                // Hide options other than 'Metrio' for MSA
                for (var i = 0; i < companyOptions.length; i++) {
                    var option = companyOptions[i];
                    if (i === 0) {
                        // Hide the first option
                        option.style.display = 'none';
                    } else {
                        option.style.display = (option.text !== 'METRIO') ? 'none' : 'block';
                    }
                }
            } else {
                // Show all companies for other roles
                for (var i = 0; i < companyOptions.length; i++) {
                    var option = companyOptions[i];
                    option.style.display = 'block';
                }
            }
        }

        // Initial setup when the page loads
        updateCompanyDropdown();
    });
</script>




@endsection

 <!-- <div class="col">
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
</div> -->