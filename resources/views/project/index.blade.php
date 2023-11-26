@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">CRUD Project</h1>
        <a href="{{ route('project.create') }}" class="btn btn-primary">Create Project</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" project="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover" id="data-table">
        <thead class="table-primary">
            @if(Auth::user()->role_name == 'Master Super Admin - MSA')
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Project</th>
                    <th>Action</th>
                </tr>
            @else
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Action</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @if($project->count() > 0)
                @foreach($project as $rs)
                    @if(Auth::user()->role_name == 'Master Super Admin - MSA')
                        @foreach($rs->companies as $company)
                            <tr>
                                <td class="align-middle">{{ $loop->parent->iteration }}</td>
                                <td class="align-middle">{{ $company->company_name }}</td>
                                <td class="align-middle">{{ $rs->project_name }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('project.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                        <a href="{{ route('project.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('project.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
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
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $rs->project_name }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('project.show', $rs->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                    <a href="{{ route('project.edit', $rs->id)}}" type="button" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('project.destroy', $rs->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Are you sure to Delete?')">
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
                    <td class="text-center" colspan="5">Project not found</td>
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
                            columns: [0,1,2] // Include all three columns in the export
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0,1,2] // Include all three columns in the export
                        }
                    }
                ]
            });
        });
    </script>
@endsection
