@extends('tgg-india.layouts.app')

@section('title', 'Welcome Notes  | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 showcase-heading">Welcome Notes Showcase</h4>
        @include('tgg-india.layouts.includes.message')

        <!-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

        <div class="card p-3 mb-4">

            <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <!-- WELCOME NOTE -->
                <div class="mb-3">
                    <label for="welcome_note" class="form-label">Welcome Note</label>
                    <textarea id="welcome_note" name="welcome_note" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note', $showcase?->welcome_note ?? '') !!}
            </textarea>
                </div>

                <div class="mb-3">
                    <label for="welcome_note_trainer" class="form-label">Welcome Note For Trainer</label>
                    <textarea id="welcome_note_trainer" name="welcome_note_trainer" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_trainer', $showcase?->welcome_note_trainer ?? '') !!}
            </textarea>
                </div>

                <div class="mb-3">
                    <label for="welcome_note_member" class="form-label">Welcome Note For Member</label>
                    <textarea id="welcome_note_member" name="welcome_note_member" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_member', $showcase?->welcome_note_member ?? '') !!}
            </textarea>
                </div>

                <div class="mb-3">
                    <label for="welcome_note_rhm_club" class="form-label">Welcome Note For Rhm Club</label>
                    <textarea id="welcome_note_rhm_club" name="welcome_note_rhm_club" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_rhm_club', $showcase?->welcome_note_rhm_club ?? '') !!}
            </textarea>
                </div>

                <div class="mb-3">
                    <label for="welcome_note_nomad_community" class="form-label">Welcome Note For Nomad Community</label>
                    <textarea id="welcome_note_nomad_community" name="welcome_note_nomad_community" class="form-control js-ckeditor"
                        rows="5">
                {!! old('welcome_note_nomad_community', $showcase?->welcome_note_nomad_community ?? '') !!}
            </textarea>
                </div>

                <div class="mb-3">
                    <label for="welcome_note_freelancer" class="form-label">Welcome Note For Freelancer</label>
                    <textarea id="welcome_note_freelancer" name="welcome_note_freelancer" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_freelancer', $showcase?->welcome_note_freelancer ?? '') !!}
            </textarea>
                </div>

               

                <button type="submit" class="btn btn-primary">Update Showcase</button>
            </form>

        </div>

    </div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.file-input-with-notes').forEach(function(input) {
        input.addEventListener('change', function(e) {
            const field = input.dataset.field;
            const container = document.querySelector('.new-' + field + '-notes');
            container.innerHTML = ''; // clear previous

            const files = Array.from(input.files || []);
            files.forEach(function(file, idx) {
                const wrapper = document.createElement('div');
                wrapper.className = 'm-1 p-2 border rounded';
                wrapper.style.width = '100%';

                const title = document.createElement('div');
                title.innerText = file.name;
                title.className = 'small fw-bold mb-1';
                wrapper.appendChild(title);

                const ta = document.createElement('textarea');
                ta.name = field + '_new_notes[]';
                ta.placeholder = 'Enter checkout note for this new image';
                ta.rows = 2;
                ta.className = 'form-control form-control-sm mb-1';
                wrapper.appendChild(ta);

                container.appendChild(wrapper);
            });
        });
    });
});
</script>
@endpush
