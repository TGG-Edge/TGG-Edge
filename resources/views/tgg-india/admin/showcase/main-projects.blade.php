@extends('tgg-india.layouts.app')

@section('title', 'Main Projects | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 showcase-heading">Main Projects Showcase</h4>
        @include('tgg-india.layouts.includes.message')

        <!-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

        <div class="card p-3 mb-4">

            <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
                @csrf


               
                <!-- IMAGE FIELDS -->
                @foreach ([
                        'woodpecker_collection' => 'Woodpecker Collection',
                        'travel_and_events' => 'Travel & Events',
                        'tgg_foundation' => 'TGG Foundation',
                    ] as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label">{{ $label }} (Upload Multiple
                            Images)</label>
                        <input type="file" id="{{ $field }}" name="{{ $field }}[]"
                            class="form-control file-input-with-notes" multiple data-field="{{ $field }}">
                        <small class="text-muted d-block mt-1">
                            Please upload multiple images in <strong>400 x 400 px</strong> size for best results.
                        </small>

                        <div class="mt-2 d-flex flex-wrap">
                            @foreach ($showcase->{$field} ?? [] as $index => $item)
                                @php
                                    // item may be string (old data) or array ['img'=>..., 'note'=>...]
                                    $imgPath = is_array($item) ? $item['img'] ?? '' : $item;
                                    $note = is_array($item) ? $item['note'] ?? '' : '';

                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($imgPath);

                                    // Re-assign $imgPath based on environment
                                    $imgPath = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $imgPath;
                                @endphp

                                <div class="position-relative m-1 p-2 border rounded" style="width: 49%;">
                                    <img src="{{ $imgPath }}" width="200" style="    margin-left: 6.5rem !important;" class="rounded shadow mb-1">
                                    <label class="d-block text-center small mb-1">
                                        <input type="checkbox" name="remove_{{ $field }}[]"
                                            value="{{ $imgPath }}"> Remove
                                    </label>

                                    <textarea name="{{ $field }}_notes[]" class="js-ckeditor form-control form-control-sm " rows="2"
                                        placeholder="Checkout note (for this image)">{{ $note }}</textarea>
                                    <input type="hidden" name="{{ $field }}_existing[]"
                                        value="{{ $imgPath }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- new files notes area (populated by JS when admin selects files) -->
                        <div class="new-{{ $field }}-notes mt-2"></div>
                        <small class="form-text text-muted">When you select new files, a note box will appear for each file.
                            Save to store them together.</small>
                    </div>
                @endforeach

                <!-- TGG NEWS -->
                <div class="form-group">
                    <label for="tgg_news" class="form-label">TGG News (YouTube URLs, comma separated)</label>
                    <input type="text" name="tgg_news" class="form-control"
                        value="{{ old('tgg_news', implode(',', $showcase->tgg_news ?? [])) }}">
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
