@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">CRUD System Login User</h1>
        <a href="{{ route('profile.create') }}" class="btn btn-primary">Create User</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" project="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover" id="data-table">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                @if(Auth::user()->role_name == 'Master Super Admin - MSA')
                    <th>Company Name</th>
                @endif
                <th>User Login Name</th>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($profile->count() > 0)
                @foreach($profile as $rs)
                    @if(Auth::user()->role_name == 'Super Super Admin - SSA')
                        @if($rs->role_name != 'Master Super Admin - MSA')
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $rs->user_name }}</td>
                                <td class="align-middle">{{ $rs->name }}</td>
                                <td class="align-middle">{{ $rs->email }}</td>
                                <td class="align-middle">{{ $rs->role_name }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('profile.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                        <a href="{{ route('profile.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('profile.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-0">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if($rs->company)
                                    {{ $rs->company->company_name }}
                                @endif
                            </td>
                            <td class="align-middle">{{ $rs->user_name }}</td>
                            <td class="align-middle">{{ $rs->name }}</td>
                            <td class="align-middle">{{ $rs->email }}</td>
                            <td class="align-middle">{{ $rs->role_name }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('profile.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                    <a href="{{ route('profile.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('profile.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-0">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
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
