@extends('layouts.app')
  
@section('title', 'Edit Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit project</h1> -->
    
    <hr />
    <form action="{{ route('project.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Project</label>
                <input type="text" name="project_name" class="form-control" placeholder="project" value="{{ $project->project_name }}" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection