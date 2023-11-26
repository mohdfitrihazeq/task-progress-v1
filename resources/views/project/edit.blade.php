@extends('layouts.app')
  
@section('title', 'Edit Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit project</h1> -->
    
    <hr />
    <form action="{{ route('project.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        @if(Auth::user()->role_name == 'Master Super Admin - MSA')
        <div class="row">
        <div class="col mb-3">
            <label class="form-label">Companies</label>
                @foreach ($companies as $company)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="company_ids[]" value="{{ $company->company_id }}" {{ $associatedCompanies->contains($company) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $company->company_name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="col mb-3">
                <label class="form-label">Project</label>
                <input type="text" name="project_name" class="form-control" placeholder="project" value="{{ $project->project_name }}" >
            </div>
        </div>
        @else
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Project</label>
                <input type="text" name="project_name" class="form-control" placeholder="project" value="{{ $project->project_name }}" >
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection