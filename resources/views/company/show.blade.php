@extends('layouts.app')
  
@section('title', 'Show company')
  
@section('contents')
    <!-- <h1 class="mb-0">Detail company</h1> -->
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">company</label>
            <input type="text" name="title" class="form-control" placeholder="company" value="{{ $company->company_name }}" readonly>
        </div>
        <!-- <div class="col mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $company->price }}" readonly>
        </div> -->
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="{{ route('company') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col mb-3">
            <label class="form-label">company_code</label>
            <input type="text" name="company_code" class="form-control" placeholder="company Code" value="{{ $company->company_code }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Descriptoin" readonly>{{ $company->description }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $company->created_at }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $company->updated_at }}" readonly>
        </div>
    </div> -->
@endsection