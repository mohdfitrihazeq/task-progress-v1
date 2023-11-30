@extends('layouts.app')
  
@section('title', 'Create Project')
  
@section('contents')
    <!-- <h1 class="mb-0">Add project</h1> -->
    <hr />
    <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(Auth::user()->role_name == 'Master Super Admin - MSA')
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Company</label>
                    <select class="form-control" name="company_id">
                        @foreach ($companies as $company)
                            <option value="{{ $company->company_id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    <!-- Hidden input outside of the select element -->
                    <!-- <input type="hidden" name="hidden_company_id" id="hidden_company_id" value=""> -->
                </div>
                <div class="col">
                    <label class="form-label">Project</label>
                    <input type="text" name="project_name" class="form-control" placeholder="project" value="{{ old('project_name') }}"required>
                </div>
            </div>
        @else
        <div class="row mb-3">
            <div class="col">
                <!-- Hidden input outside of the select element -->
                @if($companies->isNotEmpty())
                    <input type="hidden" name="company_id" value="{{ $companies->first()->company_name }}">
                @else     
                    <input type="hidden" name="" value="">
                @endif
                <label class="form-label">Project</label>
                <input type="text" name="project_name" class="form-control" placeholder="project" required>
            </div>
        </div>
        @endif
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
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('project') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>

<script>
    function logFormData() {
        var form = document.forms[0];
        var formData = new FormData(form);
        console.log([...formData.entries()]);
    }
</script>

@endsection