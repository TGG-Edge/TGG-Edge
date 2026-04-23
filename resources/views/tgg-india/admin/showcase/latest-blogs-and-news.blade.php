@extends('tgg-india.layouts.app')

@section('title', 'Latest Blogs And News | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 showcase-heading">Latest Blogs And News Showcase</h4>
        @include('tgg-india.layouts.includes.message')

        <!-- @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
                @csrf   
                <input type="hidden" name="form_type" value="latest_blogs_and_news">

                <label class="form-label">Latest Blogs And News</label>
                <div id="opportunities-wrapper">
                    @php
                        $opportunities = $showcase->latest_blogs_and_news ?? [];
                    @endphp
                    @foreach ($opportunities as $i => $opportunity)
                        <div class="border p-2 mb-2 rounded opportunity-item">
                            <input type="text" name="latest_blogs_and_news[{{ $i }}][title]"
                                class="form-control mb-1" placeholder="Opportunity Title"
                                value="{{ $opportunity['title'] ?? '' }}">

                            <textarea name="latest_blogs_and_news[{{ $i }}][note]" class="js-ckeditor form-control mb-1"
                                placeholder="Opportunity Note">{{ $opportunity['note'] ?? '' }}</textarea>

                            <input type="file" name="latest_blogs_and_news[{{ $i }}][image]"
                                class="form-control my-1" placeholder="Opportunity image"
                                value="{{ $opportunity['image'] ?? '' }}">
                                
                            @if(!empty($opportunity['image']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $opportunity['image']) }}" 
                                        alt="Preview" 
                                        style="width: 120px; height: auto; border-radius: 6px; border: 1px solid #ddd;">
                                </div>
                            @endif

                            <input type="url" name="latest_blogs_and_news[{{ $i }}][youtube_video_link]"
                                class="form-control my-1" placeholder="Youtube Video Link"
                                value="{{ $opportunity['youtube_video_link'] ?? '' }}">



                            <input type="hidden" name="latest_blogs_and_news[{{ $i }}][updated_at]"
                                class="form-control my-1" placeholder="Opportunity updated_at"
                                value="{{ now() }}">
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-sm btn-secondary" id="add-opportunity">+ Add Opportunity</button>
                <br><br>
                <button type="submit" class="btn btn-primary">Update Showcase</button>
            </form>
        </div>




    </div>
@endsection

@push('scripts')

<script>
    // ✅ Define UploadAdapter only once
    if (typeof window.UploadAdapter === "undefined") {
        class UploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('ckeditor.upload') }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) {
                            resolve({ default: data.url });
                        } else {
                            reject(data.error || 'Upload failed');
                        }
                    })
                    .catch(reject);
                }));
            }
            abort() {}
        }
        window.UploadAdapter = UploadAdapter;
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = loader => new window.UploadAdapter(loader);
    }

    // ✅ Reusable function to init CKEditor
    function initCkeditor(el) {
        if (!el || el.dataset.ckeditorInited) return;
        el.dataset.ckeditorInited = "1";

        CKEDITOR.ClassicEditor.create(el, {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            removePlugins: [
                'CKBox','CKFinder','CKFinderUploadAdapter','EasyImage',
                'RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory','PresenceList','Comments',
                'TrackChanges','TrackChangesData','RevisionHistory','Pagination',
                'WProofreader','MathType','DocumentOutline','ExportPdf','ExportWord',
                'TableOfContents','FormatPainter','Template','SlashCommand','PasteFromOfficeEnhanced'
            ],
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', 'blockQuote', 'imageUpload', 'undo', 'redo'
            ],
            image: {
                resizeUnit: '%',
                resizeOptions: [
                    { name: 'resizeImage:original', label: 'Original', value: null },
                    { name: 'resizeImage:25', label: '25%', value: '25' },
                    { name: 'resizeImage:50', label: '50%', value: '50' },
                    { name: 'resizeImage:75', label: '75%', value: '75' }
                ],
                toolbar: [
                    'imageStyle:inline','imageStyle:block','imageStyle:side','|',
                    'resizeImage','imageTextAlternative'
                ]
            }
        }).then(editor => {
            // ✅ Apply default styles
            editor.editing.view.change(writer => {
                writer.setStyle('font-size', '13px', editor.editing.view.document.getRoot());
                writer.setStyle('color', '#000', editor.editing.view.document.getRoot());
                writer.setStyle('font-family', 'poppins, system-ui, Arial, sans-serif', editor.editing.view.document.getRoot());
            });
        }).catch(console.error);
    }

    // ✅ Initialize on page load + for new opportunities
    document.addEventListener('DOMContentLoaded', function () {
        // Init existing editors
        document.querySelectorAll('.js-ckeditor').forEach(initCkeditor);

        // Add new opportunity
        document.getElementById('add-opportunity').addEventListener('click', function () {
            const wrapper = document.getElementById('opportunities-wrapper');
            const index = wrapper.querySelectorAll('.opportunity-item').length;

            const div = document.createElement('div');
            div.className = 'border p-2 mb-2 rounded opportunity-item';
            div.innerHTML = `
                <input type="text" name="latest_blogs_and_news[${index}][title]" 
                    class="form-control mb-1" placeholder="Opportunity Title">

                <textarea name="latest_blogs_and_news[${index}][note]" 
                    class="js-ckeditor form-control mb-1" placeholder="Opportunity Note"></textarea>

                
                <input type="file" name="latest_blogs_and_news[${index}][image]" 
                    class="form-control my-1" placeholder="Image">

                <input type="url" name="latest_blogs_and_news[${index}][youtube_video_link]" 
                    class="form-control my-1" placeholder="Youtube video link">

                
            `;
            wrapper.appendChild(div);

            // Init CKEditor on the new textarea
            initCkeditor(div.querySelector('.js-ckeditor'));
        });
    });
</script>
@endpush


