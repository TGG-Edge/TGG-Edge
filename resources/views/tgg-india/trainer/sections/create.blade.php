@extends('tgg-india.layouts.app')

@section('title', 'Create Literature | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <h4 class="mb-3 trainer-heading text-center text-md-start">Create New Section</h4>

            @include('tgg-india.layouts.includes.message')

            <div class="card p-3 p-md-4 mb-4 shadow-sm">
                <form action="{{ route('tgg-india.trainer.sections.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                    </div>

                    <!-- 
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control js-ckeditor" rows="5"></textarea>
                    </div> 
                    -->

                    <div class="d-flex flex-wrap justify-content-between gap-2 mt-3">
                        <button type="submit" class="btn btn-primary flex-fill flex-md-grow-0 save-button">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
