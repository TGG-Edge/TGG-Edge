@extends('tgg-india.layouts.app')

@section('title', 'Create Chapters | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New chapter</h4>
        @include('tgg-india.layouts.includes.message')

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.chapters.store') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{ request()->section_id }}">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">content</label>
                    <textarea id="content" name="content" class="form-control js-ckeditor" rows="5">
                        {!! old(
                            'content',
                            '<div class="book-page book-chapter">
                        
                          <div class="chapter-header">
                            <h4 class="chapter-number">Chapter X</h4>
                            <h2 class="chapter-title">Chapter Title Goes Here</h2>
                          </div>
                        
                          <p class="chapter-intro">
                            This is an introductory paragraph for the chapter. 
                            You can describe the main idea or context here to give readers an overview of what this chapter covers.
                          </p>
                        
                          <!-- Section 1 --><div class="chapter-section">
                            <h3 class="section-title">1. Section Title</h3>
                        
                            <p class="section-overview"><strong>Overview:</strong> Write a short overview for this section here.</p>
                        
                            <p class="section-subtitle"><strong>Key Features:</strong></p>
                            <ul class="section-list features-list">
                              <li>Feature one description</li>
                              <li>Feature two description</li>
                              <li>Feature three description</li>
                            </ul>
                        
                            <p class="section-subtitle"><strong>Fees / Pricing:</strong></p>
                            <ul class="section-list fees-list">
                              <li>Fee or cost detail 1</li>
                              <li>Fee or cost detail 2</li>
                            </ul>
                        
                            <p class="section-subtitle"><strong>Pros:</strong></p>
                            <ul class="section-list pros-list">
                              <li>Positive point 1</li>
                              <li>Positive point 2</li>
                            </ul>
                        
                            <p class="section-subtitle"><strong>Cons:</strong></p>
                            <ul class="section-list cons-list">
                              <li>Negative point 1</li>
                              <li>Negative point 2</li>
                            </ul>
                        
                            <blockquote class="section-summary">
                              <strong>Summary:</strong> Add a short conclusion or note here.
                            </blockquote>
                            <div class="chapter-image">
                                <img src="https://dummyimage.com/400x120/cccccc/000000&amp;text=Nerve+%E2%86%92+Brain+%E2%86%92+Pain" alt="Diagram Example">
                            </div>
                          </div>
                        
                          <!-- Section 2 --><div class="chapter-section">
                            <h3 class="section-title">2. Section Title</h3>
                            <p class="section-overview"><strong>Overview:</strong> Overview text for the next section.</p>
                            <ul class="section-list features-list">
                              <li>Feature one</li>
                              <li>Feature two</li>
                            </ul>
                            <blockquote class="section-summary">
                              <strong>Summary:</strong> Short note about this section.
                            </blockquote>
                          </div>
                        
                          <!-- Activities --><div class="chapter-activities">
                            <h3 class="activities-title">Activities</h3>
                            <ul class="activities-list">
                              <li>Activity 1: Describe your learning</li>
                              <li>Activity 2: Create a small checklist</li>
                            </ul>
                          </div>
                        
                          <div class="page-footer">
                            — Page X —
                          </div>
                        
                        </div>
                        ',
                        ) !!}
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>
@endsection
