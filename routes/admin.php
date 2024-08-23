<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\ChartOfAccountController;
use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DropzoneController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FeatureTitleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MemberHistoryController;
use App\Http\Controllers\Admin\PackageManageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UploadDocumentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserHistoryController;
use App\Http\Controllers\Admin\UserPrefixController;

use App\Http\Controllers\Admin\Payroll\PayrollDepartmentController;
use App\Http\Controllers\Admin\Payroll\PayrollEmployeeController;
use App\Http\Controllers\Admin\Payroll\PayrollFinancialRecordController;
use App\Http\Controllers\Admin\Payroll\PayrollSalaryController;
use App\Http\Controllers\Admin\Payroll\PayrollSettingController;
use App\Http\Controllers\Admin\Products\SalePromotionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Import\PayrollEmployeeImport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('storage_link', function () {
    Artisan::call('storage:link');
});

Route::get('config_clear', function () {
    Artisan::call('config:clear');
});


Route::get('login', [LoginController::class, 'showLoginform']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout']);

Auth::routes();

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::group(['middleware' => ['is_active']], function () {
            Route::get('/', [DashboardController::class, 'index']);

            // Route::prefix('admin')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('home');
            Route::resource('/dashboard', DashboardController::class);
            //Main Menu

            // Article
            Route::group(['middleware' => ['permission:*|all article|view article']], function () {
                Route::resource('/article', ArticleController::class);
                Route::get('/article/publish/{id}', [ArticleController::class, 'publish'])->name('article.publish');
                Route::get('/article/sort/{id}', [ArticleController::class, 'sort'])->name('article.sort');
            });

            //Manage Package
            Route::group(['middleware' => ['permission:*|all package_manage|view package_manage']], function () {
                Route::get('/package_manage', [PackageManageController::class, 'index'])->name('package_manage.index');
                Route::post('/package_manage/store', [PackageManageController::class, 'store'])->name('package_manage.store');
                Route::get('/package_manage/edit/{id}', [PackageManageController::class, 'edit'])->name('package_manage.edit');
                Route::post('/package_manage/update', [PackageManageController::class, 'update'])->name('package_manage.update');
                Route::delete('/package_manage/destroy/{id}', [PackageManageController::class, 'destroy'])->name('package_manage.destroy');
                Route::get('/package_manage/publish/{id}', [PackageManageController::class, 'publish'])->name('package_manage.publish');
                Route::get('/package_manage/sort/{id}', [PackageManageController::class, 'sort'])->name('package_manage.sort');
            });

            //Feature Title
            Route::group(['middleware' => ['permission:*|all feature_title|view feature_title']], function () {
                Route::get('/feature_title', [FeatureTitleController::class, 'index'])->name('feature_title.index');
                Route::post('/feature_title/store', [FeatureTitleController::class, 'store'])->name('feature_title.store');
                Route::get('/feature_title/edit/{id}', [FeatureTitleController::class, 'edit'])->name('feature_title.edit');
                Route::post('/feature_title/update', [FeatureTitleController::class, 'update'])->name('feature_title.update');
                Route::delete('/feature_title/destroy/{id}', [FeatureTitleController::class, 'destroy'])->name('feature_title.destroy');
                Route::get('/feature_title/publish/{id}', [FeatureTitleController::class, 'publish'])->name('feature_title.publish');
                Route::get('/feature_title/sort/{id}', [FeatureTitleController::class, 'sort'])->name('feature_title.sort');
            });

            //Feature
            Route::group(['middleware' => ['permission:*|all feature|view feature']], function () {
                Route::get('/feature', [FeatureController::class, 'index'])->name('feature.index');
                Route::post('/feature/store', [FeatureController::class, 'store'])->name('feature.store');
                Route::get('/feature/edit/{id}', [FeatureController::class, 'edit'])->name('feature.edit');
                Route::post('/feature/update', [FeatureController::class, 'update'])->name('feature.update');
                Route::delete('/feature/destroy/{id}', [FeatureController::class, 'destroy'])->name('feature.destroy');
                Route::get('/feature/publish/{id}', [FeatureController::class, 'publish'])->name('feature.publish');
                Route::get('/feature/sort/{id}', [FeatureController::class, 'sort'])->name('feature.sort');
            });

            Route::group(['middleware' => ['permission:*|all member|view member']], function () {
                Route::resource('/member', MemberController::class);
                Route::get('/member/publish/{id}', [MemberController::class, 'publish'])->name('member.publish');
                Route::get('/member/softdel/{id}', [MemberController::class, 'softDel'])->name('member.softDel');
                Route::get('/member/sort/{id}', [MemberController::class, 'sort'])->name('member.sort');
            });

            //Member History
            Route::group(['middleware' => ['permission:*|all member_history|view member_history']], function () {
                Route::get('/member_history', [MemberHistoryController::class, 'index'])->name('member_history.index');
                Route::get('/member_history/recovery/{id}', [MemberHistoryController::class, 'recovery'])->name('member_history.recovery');
                Route::delete('/member_history/destroy/{id}', [MemberHistoryController::class, 'destroy'])->name('member_history.destroy');
            });

            //Prefix
            Route::group(['middleware' => ['permission:*|all prefix|view prefix']], function () {
                Route::get('/prefix', [UserPrefixController::class, 'index'])->name('prefix.index');
                Route::post('/prefix/store', [UserPrefixController::class, 'store'])->name('prefix.store');
                Route::get('/prefix/edit/{id}', [UserPrefixController::class, 'edit'])->name('prefix.edit');
                Route::post('/prefix/update', [UserPrefixController::class, 'update'])->name('prefix.update');
                Route::delete('/prefix/destroy/{id}', [UserPrefixController::class, 'destroy'])->name('prefix.destroy');
                Route::get('/prefix/publish/{id}', [UserPrefixController::class, 'publish'])->name('prefix.publish');
            });

            //Bank
            Route::group(['middleware' => ['permission:*|all bank|view bank']], function () {
                Route::get('/bank', [BankController::class, 'index'])->name('bank.index');
                Route::post('/bank/store', [BankController::class, 'store'])->name('bank.store');
                Route::get('/bank/edit/{id}', [BankController::class, 'edit'])->name('bank.edit');
                Route::post('/bank/update', [BankController::class, 'update'])->name('bank.update');
                Route::delete('/bank/destroy/{id}', [BankController::class, 'destroy'])->name('bank.destroy');
                Route::get('/bank/publish/{id}', [BankController::class, 'publish'])->name('bank.publish');
            });

            //User
            Route::group(['middleware' => ['permission:*|all user|view user']], function () {
                Route::get('/user', [UserController::class, 'index'])->name('user.index');
                Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
                Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
                Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

                Route::get('/user/publish/{id}', [UserController::class, 'publish'])->name('user.publish');
            });

            //User History
            Route::group(['middleware' => ['permission:*|all user_history|view user_history']], function () {
                Route::get('/user_history', [UserHistoryController::class, 'index'])->name('user_history.index');
                Route::get('/user_history/recovery/{id}', [UserHistoryController::class, 'recovery'])->name('user_history.recovery');
                Route::delete('/user_history_history/destroy/{id}', [UserHistoryController::class, 'destroy'])->name('user_history.destroy');
            });

            //Role
            Route::group(['middleware' => ['permission:*|all role|view role']], function () {
                Route::resource('/role', RoleController::class);
                // Route::get('/role', [RoleController::class,'index'])->name('role.index');
                // Route::post('/role/store', [RoleController::class,'store'])->name('role.store');
                // Route::get('/role/edit/{id}', [RoleController::class,'edit'])->name('role.edit');
                // Route::post('/role/update', [RoleController::class,'update'])->name('role.update');
                // Route::delete('/role/destroy/{id}', [RoleController::class,'destroy'])->name('role.destroy');
            });

            //Permission
            Route::group(['middleware' => ['permission:*|all permission|view permission']], function () {
                Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
                Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
                Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
                Route::post('/permission/update', [PermissionController::class, 'update'])->name('permission.update');
                Route::delete('/permission/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
            });

            //Website Setting
            Route::group(['middleware' => ['permission:*|website_setting']], function () {
                Route::resource('/setting', SettingController::class);
            });

            //User Profile
            Route::get('/user/profile/{user}', [UserController::class, 'profile'])->name('user.profile');
            Route::put('/user/profile/update/{user}', [UserController::class, 'update_profile'])->name('user.profile.update');
            // });

            // Upload Document
            Route::group(['middleware' => ['permission:*|all uploadDocument|view uploadDocument']], function () {
                Route::get('/uploadDocument', [UploadDocumentController::class, 'index'])->name('uploadDocument.index');
                Route::post('/uploadDocument/store', [UploadDocumentController::class, 'store'])->name('uploadDocument.store');
                Route::get('/uploadDocument/edit/{id}', [UploadDocumentController::class, 'edit'])->name('uploadDocument.edit');
                Route::post('/uploadDocument/update', [UploadDocumentController::class, 'update'])->name('uploadDocument.update');
                Route::delete('/uploadDocument/destroy/{id}', [UploadDocumentController::class, 'destroy'])->name('uploadDocument.destroy');
                Route::get('/uploadDocument/publish/{id}', [UploadDocumentController::class, 'publish'])->name('uploadDocument.publish');

                Route::get('/document/fileVaultCreate', [UploadDocumentController::class, 'fileVaultCreate'])->name('uploadDocument.fileVaultCreate');
            });

            //Contact
            Route::group(['middleware' => ['permission:*|all contact|view contact']], function () {
                Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
                Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
                Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
                Route::post('/contact/update', [ContactController::class, 'update'])->name('contact.update');
                Route::delete('/contact/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
                Route::get('/contact/publish/{id}', [ContactController::class, 'publish'])->name('contact.publish');
            });

            //Product
            Route::group(['middleware' => ['permission:*|all product|view product']], function () {
                Route::get('/product', [ProductController::class, 'index'])->name('product.index');
                Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
                Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
                Route::post('/product/update', [ProductController::class, 'update'])->name('products.update');
                Route::delete('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
                Route::get('/product/publish/{id}', [ProductController::class, 'publish'])->name('product.publish');
            });

            //Unit
            Route::group(['middleware' => ['permission:*|all unit|view unit']], function () {
                Route::resource('/unit', UnitController::class);
                Route::delete('/unit/destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
                Route::get('/unit/publish/{id}', [UnitController::class, 'publish'])->name('unit.publish');
            });

            //Sale
            Route::group(['middleware' => ['permission:*|all sales|view slaes']], function () {
                Route::resource('/salepromo', SalePromotionController::class);
            });

            // Payroll
            Route::group(['middleware' => ['permission:*|all payroll_setting|view payroll_setting']], function () {
                Route::get('/payroll_setting/', [PayrollSettingController::class, 'index'])->name('payroll_setting.index');
                Route::post('/payroll_setting/update', [PayrollSettingController::class, 'update'])->name('payroll_setting.update');
            });

            // Salary
            Route::group(['middleware' => ['permission:*|all payroll_salary|view payroll_salary']], function () {
                Route::resource('/payroll_salary', PayrollSalaryController::class);
            });

            // Department
            Route::group(['middleware' => ['permission:*|all payroll_department|view payroll_department']], function () {
                Route::get('/payroll_department/', [PayrollDepartmentController::class, 'index'])->name('payroll_department.index');
                Route::post('/payroll_department/store', [PayrollDepartmentController::class, 'store'])->name('payroll_department.store');
                Route::get('/payroll_department/edit/{id}', [PayrollDepartmentController::class, 'edit'])->name('payroll_department.edit');
                Route::post('/payroll_department/update', [PayrollDepartmentController::class, 'update'])->name('payroll_department.update');
                Route::delete('/payroll_department/destroy/{id}', [PayrollDepartmentController::class, 'destroy'])->name('payroll_department.destroy');
                Route::get('/payroll_department/publish/{id}', [PayrollDepartmentController::class, 'publish'])->name('payroll_department.publish');
            });

            // Financial  Records
            Route::group(['middleware' => ['permission:*|all payroll_financial_record|view payroll_financial_record']], function () {
                Route::get('/payroll_financial_record/', [PayrollFinancialRecordController::class, 'index'])->name('payroll_financial_record.index');
                Route::post('/payroll_financial_record/store', [PayrollFinancialRecordController::class, 'store'])->name('payroll_financial_record.store');
                Route::get('/payroll_financial_record/edit/{id}', [PayrollFinancialRecordController::class, 'edit'])->name('payroll_financial_record.edit');
                Route::post('/payroll_financial_record/update', [PayrollFinancialRecordController::class, 'update'])->name('payroll_financial_record.update');
                Route::delete('/payroll_financial_record/destroy/{id}', [PayrollFinancialRecordController::class, 'destroy'])->name('payroll_financial_record.destroy');
                Route::get('/payroll_financial_record/publish/{id}', [PayrollFinancialRecordController::class, 'publish'])->name('payroll_financial_record.publish');
            });

            // Employee
            Route::group(['middleware' => ['permission:*|all payroll_employee|view payroll_employee']], function () {
                Route::resource('/payroll_employee', PayrollEmployeeController::class);
                Route::get('/payroll_employee/publish/{id}', [PayrollEmployeeController::class, 'publish'])->name('payroll_employee.publish');
                Route::get('/payroll_employee/sort/{id}', [PayrollEmployeeController::class, 'sort'])->name('payroll_employee.sort');
            });

            // Chart of Account
            Route::group(['middleware' => ['permission:*|all chart_of_account|view chart_of_account']], function () {
                Route::get('/chart_of_account/', [ChartOfAccountController::class, 'index'])->name('chart_of_account.index');
                Route::post('/chart_of_account/store', [ChartOfAccountController::class, 'store'])->name('chart_of_account.store');
                Route::get('/chart_of_account/edit/{id}', [ChartOfAccountController::class, 'edit'])->name('chart_of_account.edit');
                Route::post('/chart_of_account/update', [ChartOfAccountController::class, 'update'])->name('chart_of_account.update');
                Route::delete('/chart_of_account/destroy/{id}', [ChartOfAccountController::class, 'destroy'])->name('chart_of_account.destroy');
            });

            //Dropzone
            Route::post('/dropzone/upload', [DropzoneController::class, 'uploadimage'])->name('dropzone.upload');
            Route::post('/dropzone/delete', [DropzoneController::class, 'deleteupload'])->name('dropzone.delete');

            //Summernote
            Route::post('/summernote/upload', [SummernoteController::class, 'uploadimage'])->name('summernote.upload');
            Route::post('/summernote/delete', [SummernoteController::class, 'deleteupload'])->name('summernote.delete');

            //CKEditor
            Route::post('/ckeditor/upload', [CKEditorController::class, 'uploadImage'])->name('ckeditor.upload');
            Route::post('/ckeditor/delete', [CKEditorController::class, 'deleteImage'])->name('ckeditor.delete');

            // IMPORT
            Route::post('/import/payroll/employee', [PayrollEmployeeImport::class, 'importPayrollEmployee'])->name('import.payroll.employee');

        });

        Route::get('/clc', function () {
            Artisan::call('cache:clear');
            // Artisan::call('config:clear');
            // Artisan::call('config:cache');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            // Artisan::call('optimize');
            // Artisan::call('clear-compiled');
            // Artisan::call('view:clear');
            // session()->forget('key');
            return "Cleared!";
        });
    }
);
