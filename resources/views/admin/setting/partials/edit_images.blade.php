<div class="row">
    <div class="col-sm-12">
        <blockquote class="quote-success text-lg" style="margin: 0 !important;">
            รูปภาพ
        </blockquote>
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="mb-3">
                    <div class="text-center">
                        <label class="form-label">โลโก้ เว็บไซต์</label><br />
                        <img class="resize"
                            src="@if (setting('img_logo')) {{ asset(setting('img_logo')) }} @else {{ asset('images/no-image.jpg') }} @endif"
                            id="showimg_logo" height="200" style="max-width: 100%; object-fit: contain;"> <br />
                        <span class="form-label text-danger">**รูปภาพขนาด 500x500 px** </span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img_logo" id="img_logo" accept="image/*"
                            onchange="return fileValidation(this)">
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <div class="text-center">
                        <label class="form-label">Favicon</label><br />
                        <img src="@if (setting('img_favicon')) {{ asset(setting('img_favicon')) }} @else {{ asset('images/no-image.jpg') }} @endif"
                            id="showimg_favicon" height="200" style="max-width: 100%; object-fit: contain;"> <br />
                        <span class="text-danger">**รูปภาพขนาด 100x100 px**</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img_favicon" id="img_favicon"
                            accept="image/*" onchange="return fileValidation(this)">
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3">
                    <div class="text-center">
                        <label class="form-label">OG Image</label> <br />
                        <img src="@if (setting('img_og')) {{ asset(setting('img_og')) }} @else {{ asset('images/no-image.jpg') }} @endif"
                            id="showimg_og" height="200" style="max-width: 100%; object-fit: contain;"> <br />
                        <span class="text-danger">**รูปภาพขนาด 150x150 px**</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img_og" id="img_og" accept="image/*"
                            onchange="return fileValidation(this)">
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
