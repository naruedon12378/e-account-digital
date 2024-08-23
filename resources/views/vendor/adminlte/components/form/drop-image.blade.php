<div class="border border-1 rounded-2 p-2 mb-3">
    <div class="d-inline-flex {{ $name }}" data-name="{{ $name }}">
        <div class="p-2 upload-box">
            <label for="{{ $file_name }}">
                <img src="https://placehold.co/300x300" id="showimg" width="150"
                    height="150" style="max-width: 100%; object-fit: cover;">
                <input type="file" id="{{ $file_name }}" class="mutipleImage"
                    name="{{ $file_name }}[]" multiple hidden accept=".jpg, .jpeg, .png">
            </label>
        </div>

        @if(count($value) > 0)
            @foreach ($value as $image)
                <div class="uploadBox text-center p-2">
                    <img src="{{ serverPath($image->image_url) }}" alt="image" class="img-fluid img-thumbnail">
                    <input type="hidden" name="old_image[]" value="{{ $image->image_url }}">
                    <button type="button" class="btn btn-link text-danger text-center btnRemove"
                        data-id="{{ $image->image_url }}">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
            @endforeach
        @endif
    </div>
    <span class="text-danger invalid {{ $file_name }}"></span>
    <span class="text-danger invalid invalid_image"></span>
</div>