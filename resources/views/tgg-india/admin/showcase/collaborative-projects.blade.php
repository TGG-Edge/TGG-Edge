@extends('tgg-india.layouts.app')

@section('title', 'Collaborative Projects | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 showcase-heading">Collaborative Projects Showcase</h4>
        @include('tgg-india.layouts.includes.message')

        <!-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

        <div class="card p-3 mb-4">

            <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
                @csrf



                <!-- Single checkout textareas for Modicare & Motilal -->
                <div class="mb-3">
                    <label for="modicare_checkout" class="form-label">Modicare (Community Building) Information Note </label>
                    <textarea id="modicare_checkout" name="modicare_checkout" class="form-control js-ckeditor" rows="3">{{ old('modicare_checkout', $showcase->modicare_checkout ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="motilal_checkout" class="form-label">Motilal Oswal Information Note</label>
                    <textarea id="motilal_checkout" name="motilal_checkout" class="form-control js-ckeditor" rows="3">{{ old('motilal_checkout', $showcase->motilal_checkout ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="india_insure_checkout" class="form-label">India Insure Information Note</label>
                    <textarea id="india_insure_checkout"
                            name="india_insure_checkout"
                            class="form-control js-ckeditor"
                            rows="3">{{ old('india_insure_checkout', $showcase->india_insure_checkout ?? '') }}</textarea>
                </div>

           
                <div class="mb-3">
                    <label for="vestige_team_work_checkout" class="form-label">Vestige (Team Building) Information Note</label>
                    <textarea id="vestige_team_work_checkout"
                            name="vestige_team_work_checkout"
                            class="form-control js-ckeditor"
                            rows="3">{{ old('vestige_team_work_checkout', $showcase->vestige_team_work_checkout ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="via_travel_checkout" class="form-label">Via Travel Information Note</label>
                    <textarea id="via_travel_checkout"
                            name="via_travel_checkout"
                            class="form-control js-ckeditor"
                            rows="3">{{ old('via_travel_checkout', $showcase->via_travel_checkout ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tgg_foundation_checkout" class="form-label">TGG Asset & Investments pvt ltd Information Note</label>
                    <textarea id="tgg_foundation_checkout"
                            name="tgg_foundation_checkout"
                            class="form-control js-ckeditor"
                            rows="3">{{ old('tgg_foundation_checkout', $showcase->tgg_foundation_checkout ?? '') }}</textarea>
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
