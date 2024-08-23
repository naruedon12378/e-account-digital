<div class="card {{ env('CARD_THEME') }} card-outline card-outline-tabs">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ env('TEXT_THEME') }} active" id="th-tab" data-toggle="tab" href="#th"
                    role="tab" aria-controls="th" aria-selected="true">ภาษาไทย</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ env('TEXT_THEME') }}" id="en-tab" data-toggle="tab" href="#en"
                    role="tab" aria-controls="en" aria-selected="false">ภาษาอังกฤษ</a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="th" role="tabpanel" aria-labelledby="th-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">รายละเอียดย่อย (ภาษาไทย)</label>
                            <textarea type="text" class="form-control  ckEditor-short-th" name="short_about_us_th" id="about_us_short_th"
                                style="height: 100px;">{{ setting('short_about_us_th') }}</textarea>
                        </div>

                        <label class="form-label">รายละเอียดหลัก (ภาษาไทย)</label>
                        <textarea type="text" class="form-control  ckEditor-th" name="about_us_th" style="height: 100px;">{{ setting('about_us_th') }}</textarea>

                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">รายละเอียดย่อย </label>
                            <textarea type="text" class="form-control  ckEditor-short-en" name="short_about_us_en" id="about_us_short_en"
                                style="height: 100px;">{{ setting('short_about_us_en') }}</textarea>
                        </div>

                        <label class="form-label">รายละเอียดหลัก</label>
                        <textarea type="text" class="form-control  ckEditor-en" name="about_us_en" style="height: 100px;">{{ setting('short_about_us_en') }}</textarea>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
