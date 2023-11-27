@extends('layouts.app')
  
@section('title', 'Edit company')
  
@section('contents')
    <!-- <h1 class="mb-0">Edit company</h1> -->
    
    <hr />
    <form action="{{ route('company.update', $company->company_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">company</label>
                <input type="text" name="company_name" class="form-control" placeholder="company" value="{{ $company->company_name }}" required>
            </div>
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
                <a href="{{ route('company') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
@endsection