@extends('tgg-india.layouts.app')

@section('title', 'Assignment Details | TGG Meta | TGG India')


@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Assignment</h4>

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.associate.assignments.update', $assignment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text"  readonly  name="title" class="form-control" value="{{ old('title', $assignment->title) }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Description</label>
                <textarea readonly id="description" name="description" class="form-control js-ckeditor" rows="5">{{ old('description', $assignment->description) }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Task Type</label>
                <input readonly  type="text" name="task_type" value="{{ $assignment->task_type }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Status</label>
                <select readonly name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $assignment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $assignment->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('status', $assignment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Due Date</label>
                <input readonly  type="date" name="due_date" class="form-control" value="{{ old('due_date', $assignment->due_date) }}">
                @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary save-button">Update</button>
            <a href="{{ route('tgg-india.associate.assignments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Targets: prefer #description, fall back to .js-ckeditor
  const selectors = ['#description', '.js-ckeditor'];
  const nodes = Array.from(document.querySelectorAll(selectors.join(',')));
  if (!nodes.length) return;

  nodes.forEach(el => {
    const originalHtml = (el.value || el.textContent || '').trim();
    let attempts = 0;
    const maxAttempts = 30;
    const intervalMs = 150;

    const lockAttempt = () => {
      attempts++;

      // 1) If CKEditor mounted, find its editable area near this textarea
      let editorRoot = el.closest('.ck-editor') || document.querySelector('.ck-editor');
      let editable = editorRoot ? editorRoot.querySelector('.ck-editor__editable') : null;
      let toolbar  = editorRoot ? editorRoot.querySelector('.ck-toolbar') : null;

      if (editable) {
        // Force DOM-level read-only + hide toolbar
        editable.setAttribute('contenteditable', 'false');
        editable.setAttribute('aria-readonly', 'true');
        editable.classList.add('ck-read-only');
        editable.style.pointerEvents = 'none';
        if (toolbar) toolbar.style.display = 'none';

        // Ensure form submits the content: create hidden input carrying HTML
        const form = el.closest('form');
        if (form) {
          let hidden = form.querySelector('input[name="' + el.name + '"]');
          if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = el.name;
            form.appendChild(hidden);
          }
          hidden.value = editable.innerHTML || originalHtml;
        }

        clearInterval(timer);
        return;
      }

      // 2) If CKEditor library exists and this textarea hasn't been converted, create it and make read-only
      if (window.ClassicEditor && !el.closest('.ck-editor')) {
        ClassicEditor.create(el).then(editor => {
          try {
            // try both methods (some builds prefer one)
            if (typeof editor.enableReadOnlyMode === 'function') {
              editor.enableReadOnlyMode('readonly-' + Math.random().toString(36).slice(2));
            } else {
              editor.isReadOnly = true;
            }
            // hide toolbar if possible
            if (editor.ui && editor.ui.view && editor.ui.view.toolbar && editor.ui.view.toolbar.element) {
              editor.ui.view.toolbar.element.style.display = 'none';
            }

            // sync hidden input so form can submit current data (editor.getData())
            const form = el.closest('form');
            if (form) {
              let hidden = form.querySelector('input[name="' + el.name + '"]');
              if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = el.name;
                form.appendChild(hidden);
              }
              hidden.value = (typeof editor.getData === 'function') ? editor.getData() : (el.value || originalHtml);
              // keep hidden in sync (defensive — though editor is readonly)
              if (editor.model && editor.model.document) {
                editor.model.document.on('change:data', () => {
                  hidden.value = editor.getData();
                });
              }
            }
          } catch (err) {
            console.error('Error making editor read-only:', err);
          }
        }).catch(err => {
          // ignore create errors and allow fallback
          console.error('ClassicEditor.create error (fallback will run):', err);
        });

        clearInterval(timer);
        return;
      }

      // 3) If reached max attempts, fallback: replace with styled viewer + hidden input
      if (attempts >= maxAttempts) {
        const form = el.closest('form');
        const content = el.value || el.textContent || originalHtml || '';

        // Viewer div with CK content styles (no editor)
        const viewer = document.createElement('div');
        viewer.className = 'ck-content border rounded p-2';
        viewer.innerHTML = content;

        // hidden input so form still submits the description
        if (form) {
          let hidden = form.querySelector('input[name="' + el.name + '"]');
          if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = el.name;
            form.appendChild(hidden);
          }
          hidden.value = content;
        }

        // Replace textarea with viewer
        el.replaceWith(viewer);
        clearInterval(timer);
      }
    };

    const timer = setInterval(lockAttempt, intervalMs);
    lockAttempt(); // run immediately
  });
});
</script>
@endpush
