@extends('backend.layouts.layout')
@section('title', 'Gallery - King TAS College')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Gallery</h4>
                <h6>Add or delete the images shown on the website gallery page.</h6>
            </div>
        </div>

        {{-- Upload --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Images <span class="text-danger">*</span></label>
                                <input type="file" name="images[]" id="galleryFiles" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.webp" multiple required>
                                <small class="text-muted">JPG, PNG or WEBP, up to 5 MB each. You can select up to 20 images at once.</small>
                                @error('images') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                @foreach ($errors->get('images.*') as $messages)
                                    @foreach ($messages as $message)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Caption (optional)</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" maxlength="150"
                                       value="{{ old('title') }}" placeholder="Shown on the image in the website gallery">
                                @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div id="galleryPreview" class="d-flex flex-wrap mb-3"></div>

                    <button type="submit" class="btn btn-submit">Upload Images</button>
                </form>
            </div>
        </div>

        {{-- Existing images --}}
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">All images ({{ $images->count() }})</h5>

                @if ($images->isEmpty())
                    <p class="text-muted mb-0">No images yet. Upload your first image above.</p>
                @else
                    <div class="row">
                        @foreach ($images as $image)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                                <div class="border rounded h-100 d-flex flex-column">
                                    <a href="{{ $image->url }}" target="_blank" rel="noopener">
                                        <img src="{{ $image->url }}" alt="{{ $image->title ?: 'Gallery image' }}"
                                             style="width:100%;height:180px;object-fit:cover;border-radius:.25rem .25rem 0 0;">
                                    </a>
                                    <div class="p-2 d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted text-truncate me-2" title="{{ $image->title }}">{{ $image->title ?: 'No caption' }}</small>
                                        <form action="{{ route('gallery.destroy', $image) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0" title="Delete"
                                                    onclick="return confirm('Delete this image? This cannot be undone.');">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="Delete">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Small preview of the images chosen for upload.
    document.getElementById('galleryFiles').addEventListener('change', function () {
        var box = document.getElementById('galleryPreview');
        box.innerHTML = '';
        Array.prototype.forEach.call(this.files, function (file) {
            if (!file.type.startsWith('image/')) return;
            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.cssText = 'width:90px;height:90px;object-fit:cover;border-radius:6px;margin:0 8px 8px 0;border:1px solid #e5e7eb;';
            box.appendChild(img);
        });
    });
</script>
@endsection
