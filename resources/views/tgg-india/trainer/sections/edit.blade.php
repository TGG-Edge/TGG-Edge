@extends('tgg-india.layouts.app')

@section('title', 'Edit Section | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <h4 class="mb-3 trainer-heading text-center text-md-start">Edit Section</h4>

            @include('tgg-india.layouts.includes.message')

            <div class="card p-3 p-md-4 mb-4 shadow-sm">
                <form action="{{ route('tgg-india.trainer.sections.update', $section->id) }}" method="POST" class="needs-validation">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Section Title</label>
                        <input 
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $section->title) }}" 
                            placeholder="Enter section title" 
                            required
                        >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex flex-wrap justify-content-between gap-2 mt-3">
                        <button type="submit" class="btn btn-primary flex-fill flex-md-grow-0">Update</button>
                        <a href="{{ route('tgg-india.trainer.sections.index') }}" class="btn btn-secondary flex-fill flex-md-grow-0">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
