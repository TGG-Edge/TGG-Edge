@extends('tgg-india.layouts.app')

@section('title', 'Edit Template | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    {{-- Header --}}
    <div class="row mb-3">
        <div class="col-12 col-md-6 d-flex align-items-center">
            <h4 class="trainer-heading mb-3">Edit Template</h4>
        </div>

        <div class="col-12 col-md-6 d-flex align-items-center justify-content-md-end">
            <a href="{{ route('tgg-india.templates.index',[$user->role_key]) }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">

        <form method="POST"
              action="{{ route('tgg-india.templates.update', $template->id) }}">
            @csrf

            <div class="row g-3">

                {{-- Template Name --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Template Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $template->name) }}"
                           required>
                </div>

                {{-- Template Type --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Template Type</label>
                    <select name="type" class="form-control" required>
                        @foreach(['email','whatsapp','sms','notification'] as $type)
                            <option value="{{ $type }}"
                                {{ old('type', $template->type) === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Subject</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $template->title) }}"
                           placeholder="Optional">
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label">Invite link</label>
                    <input type="text"
                           name="invite_link"
                           class="form-control"
                           value="{{ old('invite_link', $template->invite_link) }}"
                           placeholder="Optional">
                </div>

                {{-- Status --}}
                <div class="col-md-6 col-12">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active"
                            {{ old('status', $template->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive"
                            {{ old('status', $template->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                {{-- Template Body --}}
                <div class="col-12">
                    <label class="form-label">Template Content</label>
                    <textarea name="body"
                              rows="6"
                              class="form-control js-ckeditor"
                              required>{{ old('body', $template->content['body'] ?? '') }}</textarea>

                    {{-- <small class="text-muted">
                        Use variables like <code>{{'{{name}}'}}</code>,
                        <code>{{'{{email}}'}}</code>,
                        <code>{{'{{phone}}'}}</code>
                    </small> --}}
                </div>

                {{-- Variables --}}
                {{-- <div class="col-12">
                    <label class="form-label">Variables (comma separated)</label>
                    <input type="text"
                           name="variables"
                           class="form-control"
                           value="{{ old('variables', implode(',', $template->content['variables'] ?? [])) }}"
                           placeholder="name,email,phone">
                </div> --}}

            </div>

            {{-- Submit --}}
            <div class="mt-3">
                <button type="submit" class="btn btn-primary save-button">
                    <i class="bi bi-save"></i> Update Template
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
