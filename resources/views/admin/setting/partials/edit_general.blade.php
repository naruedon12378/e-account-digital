<div class="row">

    <div class="col-sm-6">
        <blockquote class="quote-success text-lg" style="margin: 0 !important;">
            ข้อมูลทั่วไป
        </blockquote>
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">ชื่อไตเติ้ลเว็บไซต์ (ภาษาไทย)</label>
                    <input type="text" class="form-control " name="title_th" value="{{ setting('title_th') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">ที่อยู่ (ภาษาไทย)</label>
                    <textarea type="text" class="form-control " name="address_th">{{ setting('address_th') }}</textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">ชื่อไตเติ้ลเว็บไซต์ (ภาษาอังกฤษ)</label>
                    <input type="text" class="form-control " name="title_en" value="{{ setting('title_en') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">ที่อยู่ (ภาษาอังกฤษ)</label>
                    <textarea type="text" class="form-control " name="address_en">{{ setting('address_en') }}</textarea>
                </div>
            </div>
        </div>

        <blockquote class="quote-success text-lg" style="margin: 0 !important;">
            ข้อมูลติดต่อ
        </blockquote>
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="tel" class="form-control  inputmask-phone" name="phone1"
                        value="{{ setting('phone1') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">อีเมล</label>
                    <input type="text" class="form-control " name="email1" value="{{ setting('email1') }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Goole Map</label> <small class="text-danger">(width="100%"
                height="450")</small>
            <textarea rows="8" class="form-control " name="google_map">{{ setting('google_map') }}</textarea>
        </div>

    </div>
    <div class="col-sm-6">
        <blockquote class="quote-success text-lg" style="margin: 0 !important;">
            โซเชียลมีเดีย
        </blockquote>
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">Line</label>
                    <input type="text" class="form-control " name="line" value="{{ setting('line') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label class="form-label">Line Token</label> <small class="text-danger">(Token
                        สำหรับ Line Notify)</small>
                    <input type="text" class="form-control " name="line_token" value="{{ setting('line_token') }}">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Facebook</label> <small class="text-danger">(แฟนเพจ)</small>
            <input type="text" class="form-control " name="facebook" value="{{ setting('facebook') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tag Google Analytic</label>
            <textarea type="text" class="form-control " name="tag_google_analytics" rows="8">{{ setting('tag_google_analytics') }}</textarea>
        </div>

    </div>
</div>
