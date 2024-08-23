<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefixes', function (Blueprint $table) {
            $table->id();
            $table->string('name_th')->nullable()->comment('คำนำหน้าชื่อ (ภาษาไทย)');
            $table->string('name_en')->nullable()->comment('คำนำหน้าชื่อ (ภาษาอังกฤษ)');
            $table->string('slug');

            $table->boolean('status')->default(1)->comment('สถานะ (0, 1)');
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_code')->nullable();
            $table->string('tax_number')->nullable()->comment('เลขประจำตัวเสียภาษี');
            $table->string('name_th')->nullable();
            $table->string('name_en')->nullable();
            $table->tinyInteger('branch')->comment('0=no,1=yes')->default(0);
            $table->string('branch_no')->nullable();
            $table->string('branch_name')->nullable();
            $table->boolean('publish')->default(1)->comment('สถานะการเผยแพร่ (0, 1)');
            $table->string('phone')->comment('เบอร์ติดต่อ')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('line')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('vat_status')->default(0)->comment('สถานะ VAT 0=no,1=yes');
            // $table->integer('type_registration')->nullable()->comment('ประเภทกิจการ');
            // $table->dateTime('business_registration_date')->nullable();
            // $table->dateTime('vat_registration_date')->nullable();
            // $table->dateTime('date_expired')->nullable();
            // $table->string('description')->nullable();
            $table->unsignedBigInteger('type_business_id')->nullable();
            $table->unsignedBigInteger('category_business_id')->nullable();
            $table->unsignedBigInteger('register_vat_id')->comment('FK ประเภทการเสียภาษีมูลค่าเพิ่ม')->nullable();

            $table->tinyInteger('social_security_status')->default(0)->comment('สถานะประกันสังคม 0=no,1=yes');
            $table->tinyInteger('social_security_branch_type')->default(1)->comment('1=HQ, 2=Branch');
            $table->string('social_security_id', 10)->nullable()->comment('เลขประกันสังคม');
            $table->string('social_security_branch_id', 6)->default('000000')->comment('เลขประกันสังคม (สาขา)');
            $table->integer('employers_social_security_rate')->default(5)->comment('อัตราเงินสมทบส่วนของนายจ้าง (%)');
            $table->integer('employers_maximum_amount')->default(750)->comment('เงินสมทบสูงสุดของนายจ้าง');
            $table->integer('employees_social_security_rate')->default(5)->comment('อัตราเงินสมทบส่วนของลูกจ้าง (%)');
            $table->integer('employees_maximum_amount')->default(750)->comment('เงินสมทบสูงสุดของลูกจ้าง');

            $table->tinyInteger('pvd_status')->default(0)->comment('กองทุนสำรองเลี้ยงชีพ 0=no,1=yes');
            $table->integer('pvd_rate')->default(3)->comment('อัตราเงินหักกองทุนสำรองเลี้ยงชีพ (%)');

            $table->unsignedBigInteger('paid_salary_account_id')->nullable()->comment('บัญชีจ่ายเงินเดือน');
            $table->integer('day_of_paid_salary')->default(1)->comment('วันที่จ่ายเงินเดือน **0=วันสุดท้ายของทุกเดือน');
            $table->timestamps();

            $table->foreign('type_business_id')->references('id')->on('type_businesses')->onDelete('cascade');
            $table->foreign('category_business_id')->references('id')->on('category_businesses')->onDelete('cascade');
            $table->foreign('register_vat_id')->references('id')->on('register_vats')->onDelete('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_code')->nullable()->comment('เลขประจำตัวผู้ใช้งาน');
            $table->string('slug');
            $table->string('firstname')->nullable()->comment('ชื่อ');
            $table->string('lastname')->nullable()->comment('นามสกุล');
            $table->string('phone')->nullable()->comment('เบอร์โทรศัพท์');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('sort')->default(0);
            $table->boolean('status')->default(1)->comment('สถานะการใช้งาน (0, 1)');
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();

            $table->timestamps();

            $table->unsignedBigInteger('company_id')->nullable()->comment('FK บริษัท');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefixes');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('users');
    }
};
