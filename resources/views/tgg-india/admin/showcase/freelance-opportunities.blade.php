@extends('tgg-india.layouts.app')

@section('title', 'Freelance Opportunities | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 showcase-heading">Freelance Opportunities Showcase</h4>
        @include('tgg-india.layouts.includes.message')

        <!-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

        <div class="card p-3 mb-4">

            <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
                @csrf


             

                <!-- INVESTMENT -->
                <div class="form-group">
                    <label for="investment_opportunities" class="form-label">Freelancing Opportunities (comma
                        separated)</label>
                    <input type="text" name="investment_opportunities" class="form-control"
                        value="{{ old('investment_opportunities', implode(',', $showcase->investment_opportunities ?? [])) }}">
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
