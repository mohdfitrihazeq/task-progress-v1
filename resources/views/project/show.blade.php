@extends('layouts.app')
  
@section('title', 'Show Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail project</h1> -->
    <hr />
    @if(Auth::user()->role_name == 'Master Super Admin - MSA')
    <div class="row">
        @foreach($associatedCompanies as $company)
            <div class="col mb-3">
                <label class="form-label">Company</label>
                <input type="text" name="title" class="form-control"  name="company_name" value="{{ $company->company_name }}" readonly>
            </div>
        @endforeach
        <div class="col mb-3">
            <label class="form-label">Project</label>
            <input type="text" name="title" class="form-control" placeholder="Project" value="{{ $project->project_name }}" readonly>
        </div>
    </div>
    @else
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Project</label>
                <input type="text" name="title" class="form-control" placeholder="Project" value="{{ $project->project_name }}" readonly>
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
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col mb-3">
            <label class="form-label">project_code</label>
            <input type="text" name="project_code" class="form-control" placeholder="project Code" value="{{ $project->project_code }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Descriptoin" readonly>{{ $project->description }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $project->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $project->updated_at }}" readonly>
        </div>
    </div> -->
@endsection