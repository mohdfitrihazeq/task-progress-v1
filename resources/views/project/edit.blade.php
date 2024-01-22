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
            <label class="form-label">Company</label>
                <select name="company_id" class="form-control">
                    @foreach ($companies as $company)
                        <option value="{{ $company->company_id }}" {{ $associatedCompanies->contains($company) ? 'selected' : '' }}>{{ $company->company_name }}</option>
                    @endforeach
                </select>
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
        <div class="row">
            <div class="col">
                <label class="form-label">Number of Backdated Date Days</label>
            </div>
            <div class="col">
                <input min="2" max="550" type="number" name="backdated_date_days" class="form-control" placeholder="2" value="{{ $project->backdated_date_days }}"required>
            </div>
            <div class="col-md-6"></div>
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
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection