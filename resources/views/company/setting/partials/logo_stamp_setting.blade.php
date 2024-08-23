<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.logo_stamp') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <div class="text-center">
                        <label class="form-label">{{ __('payroll_setting.logo') }}</label><br />
                        <img class="resize mb-3" src="{{ $logo }}" id="showimg_logo" height="100"
                            style="max-width: 100%; object-fit: contain;">
                        <br />
                        <span class="form-label text-danger">**รูปภาพขนาด 500x500 px** </span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img_logo" id="img_logo" accept="image/*"
                            onchange="return fileValidation(this)">
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <div class="text-center">
                        <label class="form-label">{{ __('payroll_setting.stamp') }}</label><br />
                        <img class="resize mb-3" src="{{ $stamp }}" id="showimg_stamp" height="100"
                            style="max-width: 100%; object-fit: contain;">
                        <br />
                        <span class="form-label text-danger">**รูปภาพขนาด 500x500 px** </span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img_stamp" id="img_stamp" accept="image/*"
                            onchange="return fileValidation(this)">
                        <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
