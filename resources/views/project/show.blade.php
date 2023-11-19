@extends('layouts.app')
  
@section('title', 'Show Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail project</h1> -->
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Project</label>
            <input type="text" name="title" class="form-control" placeholder="Project" value="{{ $project->project_name }}" readonly>
        </div>
        <!-- <div class="col mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $project->price }}" readonly>
        </div> -->
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