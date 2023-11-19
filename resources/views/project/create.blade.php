@extends('layouts.app')
  
@section('title', 'Create Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Add project</h1> -->
    <hr />
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="project_name" class="form-control" placeholder="project">
            </div>
            <!-- <div class="col">
                <input type="text" name="price" class="form-control" placeholder="Price">
            </div> -->
        </div>
        <!-- <div class="row mb-3">
            <div class="col">
                <input type="text" name="product_code" class="form-control" placeholder="Product Code">
            </div>
            <div class="col">
                <textarea class="form-control" name="description" placeholder="Descriptoin"></textarea>
            </div>
        </div> -->
 
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection