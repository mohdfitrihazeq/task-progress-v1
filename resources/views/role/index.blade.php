@extends('layouts.app')
  
<!-- @section('title', 'Role') -->
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">CRUD Role</h1>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover" id="data-table">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
            @if($role->count() > 0)
                @foreach($role as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->role_name }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('roles.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{ route('roles.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('roles.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
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
                    <td class="text-center" colspan="5">Role not found</td>
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
                        columns: [0,1] // Include only the first column in the export
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0,1] // Include only the first column in the export
                    }
                }
            ]
        });
    });
</script>
@endsection