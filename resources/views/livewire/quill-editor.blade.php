<div wire:ignore>
  <div id="editor_{{ $model }}" class="quill-editor" data-model="{{ $model }}">
    {!! $content !!}
  </div>
  <div id="editor_status_{{ $model }}" class="mt-2 text-xs text-gray-500"></div>
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
    const editorId = 'editor_{{ $model }}';
    const statusId = 'editor_status_{{ $model }}';
    const el = document.getElementById(editorId);
    const statusEl = document.getElementById(statusId);
    if (!el) return;

    const quill = new Quill('#' + editorId, {
      theme: 'snow',
      placeholder: 'Write your article here... You can paste images or click the image button to upload.',
      modules: {
        toolbar: [
          [{ header: [1, 2, 3, false] }],
          ['bold','italic','underline','strike'],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }],
          ['link','image'],
          [{ 'align': [] }],
          ['blockquote','code-block'],
          ['clean']
        ],
        history: { delay: 500, maxStack: 100, userOnly: true }
      }
    });

    // Initial HTML is already in the element; Quill picks it up automatically.

    function debounce(fn, wait) {
      let t = null;
      return function(...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), wait);
      };
    }

    const updateStatus = (text) => {
      if (!statusEl) return;
      statusEl.textContent = text;
    };

    const sendContent = debounce(() => {
      const html = quill.root.innerHTML;
      if (window.Livewire) window.Livewire.dispatch('quillChanged', { model: el.dataset.model, html });
      const plain = quill.getText() || '';
      updateStatus(`${plain.trim().length} characters`);
    }, 600);

    quill.on('text-change', sendContent);

    // Custom image handler: upload to server, then insert URL
    const toolbar = quill.getModule('toolbar');
    toolbar.addHandler('image', () => {
      const input = document.createElement('input');
      input.type = 'file';
      input.accept = 'image/*';
      input.onchange = async () => {
        const file = input.files && input.files[0];
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) {
          alert('Image too large. Max 5MB.');
          return;
        }
        updateStatus('Uploading image...');
        try {
          const form = new FormData();
          form.append('image', file);
          const tokenEl = document.querySelector('meta[name="csrf-token"]');
          const token = tokenEl ? tokenEl.getAttribute('content') : '';
          const res = await fetch('/rte/upload', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            body: form
          });
          if (!res.ok) throw new Error('Upload failed');
          const data = await res.json();
          const range = quill.getSelection(true) || { index: quill.getLength() };
          quill.insertEmbed(range.index, 'image', data.url, 'user');
          quill.setSelection(range.index + 1, 0);
          updateStatus('Image uploaded');
          sendContent();
        } catch (e) {
          console.error(e);
          alert('Failed to upload image.');
          updateStatus('');
        }
      };
      input.click();
    });

    // Helper: convert base64 to File
    function dataUrlToFile(dataUrl, filename) {
      const arr = dataUrl.split(',');
      const mime = arr[0].match(/:(.*?);/)[1];
      const bstr = atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], filename, { type: mime });
    }

    // Process pasted/dragged base64 images by uploading and swapping to URL
    const uploadedCache = new Map(); // base64 => url
    let processing = false;

    async function processEmbeddedBase64Images() {
      if (processing) return;
      processing = true;
      try {
        const images = Array.from(quill.root.querySelectorAll('img'))
          .filter(img => img.src && img.src.startsWith('data:image/'));
        for (const img of images) {
          const src = img.src;
          if (uploadedCache.has(src)) {
            img.src = uploadedCache.get(src);
            continue;
          }
          updateStatus('Uploading pasted image...');
          const file = dataUrlToFile(src, 'pasted.png');
          if (file.size > 5 * 1024 * 1024) {
            alert('A pasted image exceeds 5MB and will be skipped.');
            continue;
          }
          try {
            const form = new FormData();
            form.append('image', file);
            const tokenEl = document.querySelector('meta[name="csrf-token"]');
            const token = tokenEl ? tokenEl.getAttribute('content') : '';
            const res = await fetch('/rte/upload', { method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: form });
            if (!res.ok) throw new Error('Upload failed');
            const data = await res.json();
            img.src = data.url;
            uploadedCache.set(src, data.url);
            sendContent();
          } catch (err) {
            console.error(err);
            // leave base64 as last resort, but it may hurt performance
          } finally {
            updateStatus('');
          }
        }
      } finally {
        processing = false;
      }
    }

    const scanForBase64 = debounce(processEmbeddedBase64Images, 800);
    quill.root.addEventListener('paste', () => setTimeout(scanForBase64, 50));
    quill.root.addEventListener('drop', () => setTimeout(scanForBase64, 50));
    quill.on('text-change', scanForBase64);
  });
</script>
@endpush

@error($model)
  <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
@enderror
