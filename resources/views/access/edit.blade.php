@extends('layouts.app')
  
@section('title', 'Add User Project Accessible List')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit profile</h1> -->
    
    <hr />
    <form action="{{ route('access.update', $profile->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">User Login Name</label>
                <input type="text" name="user_name" class="form-control" placeholder="profile" value="{{ $profile->user_name }}" readonly required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Project</label>
                <!-- <input type="text" name="role_name" class="form-control" placeholder="Role" value="{{ $profile->role_name }}" required> -->
                <!-- <label class="labels">Role</label> -->
                <select class="form-control" name="project_id" placeholder="Project" required>
                    @foreach ($projects as $project)
                        <option value="{{ $project->project_id }}">{{ $project->project_name }}</option>
                    @endforeach
                </select>

            </div>
            
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
                <button class="btn btn-warning">Add</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
    @if(Session::has('success'))
        <div class="alert alert-success" project="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <!-- List  -->
    <table class="table table-hover" id="data-table">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Project</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($user_accessible->count() > 0)
                @foreach($user_accessible as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @if ($rs->project)
                                {{ $rs->project->project_name }}
                            @else
                                <!-- Handle the case where $rs->project is null -->
                                No Project Assigned
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="{{ route('access.destroy', $rs->user_accessible_id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">User not found</td>
                </tr>
            @endif
        </tbody>
    </table>
<script>    
        $(document).ready(function () {
            $('#data-table').DataTable({
                dom: 'Bfrtip', // Add the export buttons to the DOM
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0,1,2,3,4] // Include all columns in the export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2,3,4] // Include all columns in the export
                        }
                    }
                ]
            });
        });
    </script>
@endsection