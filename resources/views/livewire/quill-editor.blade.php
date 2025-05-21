<div wire:ignore>
  <div id="editor_{{ $model }}" class="quill-editor">
    {!! $content !!}
  </div>
</div>

@once
  @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
  @endpush
  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
  @endpush
@endonce

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modelName = @json($model);
    const editorId  = 'editor_' + modelName;
    const initial   = @json($content);

    const quill = new Quill('#' + editorId, {
      theme: 'snow',
      modules: {
        toolbar: [
          ['bold','italic','underline'],
          ['image']
        ]
      }
    });

    // set initial HTML
    quill.root.innerHTML = initial;

    // image handler remains the same...
    // Modified text-change handler with explicit UTF-8 handling
    quill.on('text-change', () => {
      const html = quill.root.innerHTML;
      
      // Create a temporary element to handle the content
      const temp = document.createElement('div');
      temp.innerHTML = html;
      
      // Get the text content with preserved HTML
      const content = temp.innerHTML;
      
      // Send with explicit UTF-8 encoding
      const encoder = new TextEncoder();
      const decoder = new TextDecoder('utf-8');
      const encoded = decoder.decode(encoder.encode(content));
      
      @this.updateContent(encoded);
    });
    quill.getModule('toolbar').addHandler('image', () => {
      const input = document.createElement('input');
      input.setAttribute('type','file');
      input.setAttribute('accept','image/*');
      input.click();
      input.onchange = () => {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = () => {
          const base64 = reader.result;
          const range = quill.getSelection();
          quill.insertEmbed(range.index, 'image', base64);
        };
        reader.readAsDataURL(file);
      };
    });

    // single text-change handler with better encoding
    quill.on('text-change', () => {
      const html = quill.root.innerHTML;
      const blob = new Blob([html], { type: 'text/html;charset=utf-8' });
      const reader = new FileReader();
      reader.onload = () => {
        const text = reader.result;
        @this.updateContent(text);
      };
      reader.readAsText(blob, 'utf-8');
    });
  });
</script>
@endpush

@error($model)
  <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror
