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
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\Payroll\PayrollDepartmentController;
use App\Http\Controllers\Admin\Payroll\PayrollEmployeeController;
use App\Http\Controllers\Admin\Payroll\PayrollFinancialRecordController;
use App\Http\Controllers\Admin\Payroll\PayrollSalaryController;
use App\Http\Controllers\Admin\Payroll\PayrollSalarySummaryController;
use App\Http\Controllers\Admin\Payroll\PayrollSettingController;
use App\Http\Controllers\Admin\Products\ProductCategoryController;
use App\Http\Controllers\Admin\Products\ProductTypeController;
use App\Http\Controllers\Admin\Products\UnitSetController;
use App\Http\Controllers\Admin\Products\ProductSetController;
use App\Http\Controllers\Admin\SalePromotionController;
use App\Http\Controllers\Admin\Warehouses\BeginningBalanceController;
use App\Http\Controllers\Admin\Warehouses\CountStockController;
use App\Http\Controllers\Admin\Warehouses\InventoryLotController;
use App\Http\Controllers\Admin\Warehouses\IssueRequisitionController;
use App\Http\Controllers\Admin\Warehouses\InventoryController;
use App\Http\Controllers\Admin\Warehouses\InventoryStockAdjustmentController;
use App\Http\Controllers\Admin\Warehouses\InventoryStockController;
use App\Http\Controllers\Admin\Warehouses\InventoryStockHistoryController;
use App\Http\Controllers\Admin\Warehouses\IssueReturnStockController;
use App\Http\Controllers\Admin\Warehouses\ReceiptPlanningController;
use App\Http\Controllers\Admin\Warehouses\ReceiveFinishStockController;
use App\Http\Controllers\Admin\Warehouses\ReturnFinishStockController;
use App\Http\Controllers\Admin\Warehouses\TransferRequistionController;
use App\Http\Controllers\Admin\Warehouses\TransferStockController;
use App\Http\Controllers\Admin\Warehouses\WarehouseController;

use App\Http\Controllers\Company\DocsDueDateContrller;
use App\Http\Controllers\Company\DocsTransactionNumberContrller;
use App\Http\Controllers\Company\ClassificationBranchController;
use App\Http\Controllers\Company\ClassificationGroupController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\DocsRemarkController;
use App\Http\Controllers\Company\PaymentChannelController;
use App\Http\Controllers\Company\PaymentSettingController;
use App\Http\Controllers\Company\PublicLinkController;
use App\Http\Controllers\Company\TaxInvoiceController;

// Sale Ledger
use App\Http\Controllers\Sale\QuotationController;
use App\Http\Controllers\Sale\SaleInvoiceController;

// Purchase Ledger
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Purchase\PurchaseInvoiceController;
use App\Http\Controllers\Purchase\ExpenseRecordController;
use App\Http\Controllers\Purchase\PurchaseAssetOrderController;
use App\Http\Controllers\Purchase\PurchaseAssetInvoiceController;

// Setting
use App\Http\Controllers\Setting\NumberingSystemController;
use App\Http\Controllers\Setting\DueDateSettingController;

use App\Http\Controllers\Auth\LoginController;
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

            //Company Setting
            Route::group(['middleware' => ['permission:*|company_setting']], function () {
                Route::resource('/company', CompanyController::class);
            });
            //Branch Setting
            Route::group(['middleware' => ['permission:*|branch_setting']], function () {
                Route::resource('/branch', BranchController::class);
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

            // DocSetting
            Route::group(['middleware' => ['permission:*|doc_setting']], function () {
                Route::resource('/doc_setting/setting-transaction-number', DocsTransactionNumberContrller::class);
                Route::resource('/doc_setting/setting-remark', DocsRemarkController::class);
                Route::resource('/doc_setting/setting-due-date', DocsDueDateContrller::class);
                Route::resource('/doc_setting/setting-public-link', PublicLinkController::class);
                Route::resource('/doc_setting/setting-tax-invoice', TaxInvoiceController::class);
                Route::resource('/doc_setting/setting-payment-channel', PaymentChannelController::class);

                Route::get('/doc_setting/setting-classification-group/', [ClassificationGroupController::class, 'index'])->name('setting-classification-group.index');
                Route::post('/doc_setting/setting-classification-group/store', [ClassificationGroupController::class, 'store'])->name('setting-classification-group.store');
                Route::get('/doc_setting/setting-classification-group/edit/{id}', [ClassificationGroupController::class, 'edit'])->name('setting-classification-group.edit');
                Route::post('/doc_setting/setting-classification-group/update', [ClassificationGroupController::class, 'update'])->name('setting-classification-group.update');
                Route::delete('/doc_setting/setting-classification-group/destroy/{id}', [ClassificationGroupController::class, 'destroy'])->name('setting-classification-group.destroy');
                Route::get('/doc_setting/setting-classification-group/publish/{id}', [ClassificationGroupController::class, 'publish'])->name('setting-classification-group.publish');

                Route::post('/doc_setting/setting-classification-branch/store', [ClassificationBranchController::class, 'store'])->name('setting-classification-branch.store');
                Route::get('/doc_setting/setting-classification-branch/edit/{id}', [ClassificationBranchController::class, 'edit'])->name('setting-classification-branch.edit');
                Route::post('/doc_setting/setting-classification-branch/update', [ClassificationBranchController::class, 'update'])->name('setting-classification-branch.update');
                Route::delete('/doc_setting/setting-classification-branch/destroy/{id}', [ClassificationBranchController::class, 'destroy'])->name('setting-classification-branch.destroy');

                /**
                 * Author: Night
                 * Date: 15/6/2024
                 * Module: Document setting
                 */
                Route::group(['prefix' => 'doc_setting'], function () {
                    Route::resource('numbering_system', NumberingSystemController::class);
                    Route::resource('due_date', DueDateSettingController::class);
                });
            });

            // Payment Setting
            Route::group(['middleware' => ['permission:*|payment_setting']], function () {
                Route::get('/setting-payment/', [PaymentSettingController::class, 'index'])->name('setting-payment.index');
                Route::post('/setting-payment/store', [PaymentSettingController::class, 'store'])->name('setting-payment.store');
                Route::get('/setting-payment/edit/{id}', [PaymentSettingController::class, 'edit'])->name('setting-payment.edit');
                Route::post('/setting-payment/update', [PaymentSettingController::class, 'update'])->name('setting-payment.update');
                Route::delete('/setting-payment/destroy/{id}', [PaymentSettingController::class, 'destroy'])->name('setting-payment.destroy');
            });

            //Contact
            Route::group(['middleware' => ['permission:*|all contact|view contact']], function () {
                // Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
                // Route::get('/contact/store', [ContactController::class, 'store'])->name('contact.store');
                Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
                // Route::post('/contact/update', [ContactController::class, 'update'])->name('contact.update');
                Route::delete('/contact/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
                Route::get('/contact/publish/{id}', [ContactController::class, 'publish'])->name('contact.publish');

                Route::resource('contacts', ContactController::class);
            });

            // product type
            Route::group(['middleware' => ['permission:*|all product_type|view product_type']], function () {
                Route::get('/producttype/active/{id}', [ProductTypeController::class, 'toggleActive'])->name('product_type.toggle_active');
                Route::get('/producttype/sort/{id}', [ProductTypeController::class, 'sort'])->name('product_type.sort');
                Route::get('/producttypes', [ProductTypeController::class, 'index'])->name('product_type.list');
                Route::resource('/producttype', ProductTypeController::class);
            });

            // product category
            Route::group(['middleware' => ['permission:*|all product_category|view product_category']], function () {
                Route::get('/productcategory/active/{id}', [ProductCategoryController::class, 'toggleActive'])->name('product_category.active');
                Route::get('/productcategory/sort/{id}', [ProductCategoryController::class, 'sort'])->name('product_category.sort');
                Route::get('/productcategory', [ProductCategoryController::class, 'index'])->name('product_category.list');
                Route::resource('/productcategory', ProductCategoryController::class);
            });

            //Product
            Route::group(['middleware' => ['permission:*|all product|view product']], function () {
                Route::get('/products/import', [ProductController::class, 'productimport']);
                Route::get('/products/export', [ProductController::class, 'productexport']);
                Route::get('products/toggle_active/{id}', [ProductController::class, 'toggleActive']);
                Route::get('/products/publish/{id}', [ProductController::class, 'publish'])->name('product_category.publish');
                Route::get('/products/sort/{id}', [ProductController::class, 'sort'])->name('product_category.sort');
                Route::resource('products', ProductController::class);
                Route::resource('product', ProductController::class);
            });

            // //Proudct component set
            // Route::group(['middleware' => ['permission:*|all product_component_set|view product_component_set']], function () {
            //     Route::get('prodcompset/toggle_active/{id}', [ProductComponentSetController::class, 'toggleActive']);
            //     Route::get('prodcompsets', [ProductComponentSetController::class, 'index']);
            //     Route::resource('prodcompset', ProductComponentSetController::class);
            // });

            //Proudct set
            Route::group(['middleware' => ['permission:*|all product_set|view product_set']], function () {
                Route::get('productset/toggle_active/{id}', [ProductSetController::class, 'toggleActive']);
                Route::get('productsets', [ProductSetController::class, 'index']);
                Route::resource('productset', ProductSetController::class);
            });

            //Sale
            Route::group(['middleware' => ['permission:*|all sales|view slaes']], function () {
                Route::get('salepromo/toggle_active/{id}', [SalePromotionController::class, 'toggleActive']);
                Route::resource('/salepromo', SalePromotionController::class);
            });

            //Unit
            Route::group(['middleware' => ['permission:*|all unit|view unit']], function () {
                Route::get('unit/toggle_active/{id}', [UnitController::class, 'toggleActive']);
                Route::resource('units', UnitController::class);
                // Route::resource('unit', UnitController::class);
            });

            //Unit set
            Route::group(['middleware' => ['permission:*|all unit_set|view unit_set']], function () {
                Route::get('unitset/toggle_active/{id}', [UnitSetController::class, 'toggleActive']);
                Route::get('unitsets', [UnitSetController::class, 'index']);
                Route::resource('unitset', UnitSetController::class);
            });

            /**
             * AR -> Sale Ledger
             */
            Route::group(['prefix' => 'sale_ledger'], function () {
                Route::get('quotation/getProduct', [QuotationController::class, "getProduct"]);
                Route::resource('quotations', QuotationController::class);
                Route::resource('invoices', SaleInvoiceController::class);
            });

            /**
             * AP -> Purchase Ledger
             */
            Route::group(['prefix' => 'purchase_ledger'], function () {
                Route::resource('purchase_orders', PurchaseOrderController::class);
                Route::resource('purchase_invoices', PurchaseInvoiceController::class);
                Route::resource('expenses', ExpenseRecordController::class);
                Route::resource('purchase_asset_orders', PurchaseAssetOrderController::class);
                Route::resource('purchase_asset_invoices', PurchaseAssetInvoiceController::class);
            });


            // Payroll
            Route::group(['middleware' => ['permission:*|all payroll_setting|view payroll_setting']], function () {
                Route::get('/payroll_setting/', [PayrollSettingController::class, 'index'])->name('payroll_setting.index');
                Route::post('/payroll_setting/update', [PayrollSettingController::class, 'update'])->name('payroll_setting.update');
            });
            Route::group(['middleware' => ['permission:*|all payroll_salary|view payroll_salary']], function () {
                Route::resource('/payroll_salary', PayrollSalaryController::class);
            });
            Route::group(['middleware' => ['permission:*|all payroll_salary_summary|view payroll_salary_summary']], function () {
                Route::get('/payroll_salary_summary/', [PayrollSalarySummaryController::class, 'index'])->name('payroll_salary_summary.index');
                Route::post('/payroll_salary_summary/store', [PayrollSalarySummaryController::class, 'store'])->name('payroll_salary_summary.store');
                Route::get('/payroll_salary_summary/edit/{id}', [PayrollSalarySummaryController::class, 'edit'])->name('payroll_salary_summary.edit');
                Route::post('/payroll_salary_summary/update', [PayrollSalarySummaryController::class, 'update'])->name('payroll_salary_summary.update');
                Route::delete('/payroll_salary_summary/destroy/{id}', [PayrollSalarySummaryController::class, 'destroy'])->name('payroll_salary_summary.destroy');
                Route::get('/payroll_salary_summary/publish/{id}', [PayrollSalarySummaryController::class, 'publish'])->name('payroll_salary_summary.publish');
            });
            Route::group(['middleware' => ['permission:*|all payroll_department|view payroll_department']], function () {
                Route::get('/payroll_department/', [PayrollDepartmentController::class, 'index'])->name('payroll_department.index');
                Route::post('/payroll_department/store', [PayrollDepartmentController::class, 'store'])->name('payroll_department.store');
                Route::get('/payroll_department/edit/{id}', [PayrollDepartmentController::class, 'edit'])->name('payroll_department.edit');
                Route::post('/payroll_department/update', [PayrollDepartmentController::class, 'update'])->name('payroll_department.update');
                Route::delete('/payroll_department/destroy/{id}', [PayrollDepartmentController::class, 'destroy'])->name('payroll_department.destroy');
                Route::get('/payroll_department/publish/{id}', [PayrollDepartmentController::class, 'publish'])->name('payroll_department.publish');
            });
            Route::group(['middleware' => ['permission:*|all payroll_financial_record|view payroll_financial_record']], function () {
                Route::get('/payroll_financial_record/', [PayrollFinancialRecordController::class, 'index'])->name('payroll_financial_record.index');
                Route::post('/payroll_financial_record/store', [PayrollFinancialRecordController::class, 'store'])->name('payroll_financial_record.store');
                Route::get('/payroll_financial_record/edit/{id}', [PayrollFinancialRecordController::class, 'edit'])->name('payroll_financial_record.edit');
                Route::post('/payroll_financial_record/update', [PayrollFinancialRecordController::class, 'update'])->name('payroll_financial_record.update');
                Route::delete('/payroll_financial_record/destroy/{id}', [PayrollFinancialRecordController::class, 'destroy'])->name('payroll_financial_record.destroy');
                Route::get('/payroll_financial_record/publish/{id}', [PayrollFinancialRecordController::class, 'publish'])->name('payroll_financial_record.publish');
            });
            Route::group(['middleware' => ['permission:*|all payroll_employee|view payroll_employee']], function () {
                Route::resource('/payroll_employee', PayrollEmployeeController::class);
                Route::get('/payroll_employee/publish/{id}', [PayrollEmployeeController::class, 'publish'])->name('payroll_employee.publish');
                Route::get('/payroll_employee/sort/{id}', [PayrollEmployeeController::class, 'sort'])->name('payroll_employee.sort');
            });

            // Chart of Account
            Route::group(['middleware' => ['permission:*|all chart_of_account|view chart_of_account']], function () {
                Route::get('chart_of_account/get_last_acc_code/{id}', [ChartOfAccountController::class, 'getLastAccCode']);
                Route::get('chart_of_account/get_subAcc/{id}', [ChartOfAccountController::class, 'getSubAccById']);
                Route::get('chart_of_account/get_secondary/{id}', [ChartOfAccountController::class, 'getSecondaryById']);
                Route::resource('chart_of_account', ChartOfAccountController::class);
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
            Route::post('/import/payroll/employee', [App\Http\Controllers\Import\PayrollEmployeeImportController::class, 'importPayrollEmployee'])->name('import.payroll.employee');

            // Export
            Route::post('/export/payroll/employee/xlsx', [App\Http\Controllers\Export\PayrollEmployeeExportController::class, 'export'])->name('export.payroll.employee.xlsx');
            Route::get('/export/payroll/import/employee/xlsx', [App\Http\Controllers\Export\EmployeeExportController::class, 'export'])->name('export.payroll.import.employee.xlsx');
            // Route::post('/export/payroll/salary/all', [App\Http\Controllers\Export\PayrollSalary::class, 'export'])->name('export.payroll.salary.all.xlsx');

            // OTHER
            Route::post('/read/xlsx', [App\Http\Controllers\Admin\ReadXlsxController::class, 'read'])->name('read.excel');

            // Inventory & Warehouse Author By MYINT

            Route::group(['prefix' => 'warehouse'], function () {

                //InventoryStock
                Route::group(['middleware' => ['permission:*|all inventory_stock|view inventory_stock']], function () {
                    Route::get('/inventorystock/import', [InventoryStockController::class, 'inventory_stockimport']);
                    Route::get('/inventorystock/export', [InventoryStockController::class, 'inventory_stockexport']);
                    Route::get('/inventorystock/edit/{id}', [InventoryStockController::class, 'edit'])->name('inventorystock.edit');
                    Route::get('/inventorystock/toggle_active/{id}', [InventoryStockController::class, 'toggleActive'])->name('inventory_stock.toggle_active');
                    Route::resource('inventorystock', InventoryStockController::class);
                });

                //Inventory Lot
                Route::group(['middleware' => ['permission:*|all inventory_lot|view inventory_lot']], function () {
                    // Route::get('/inventory/sort/{id}', [InventoryLotController::class, 'sort'])->name('inventory.sort');
                    Route::patch('/inventorylot/{lot_id}/appvadj/{adj_id}', [InventoryLotController::class, 'approveAdjustment'])->name('inventorylot.approve_adjustment');
                    Route::patch('/inventorylot/{lot_id}/canvadj/{adj_id}', [InventoryLotController::class, 'cancelAdjustment'])->name('inventorylot.cancel_adjustment');
                    Route::patch('/inventorylot/{lot_id}/approve', [InventoryLotController::class, 'approveLot'])->name('inventorylot.approve_lot');
                    Route::resource('inventorylot', InventoryLotController::class);
                });

                //Inventory
                Route::group(['middleware' => ['permission:*|all inventory|view inventory']], function () {
                    Route::get('/inventory/sort/{id}', [InventoryController::class, 'sort'])->name('inventory.sort');
                    // Route::get('/inventory/{inventory_id}/stock', [InventoryStockController::class, 'view'])->name('inventory.view');
                    Route::resource('inventory', InventoryController::class);
                });

                //Inventory stock history
                Route::group(['middleware' => ['permission:*|all inventory_stock_history|view inventory_stock_history']], function () {
                    // Route::get('/inventorystockhistory/sort/{id}', [InventoryAdjustmentController::class, 'sort'])->name('inventory.sort');
                    Route::resource('inventorystockhistory', InventoryStockHistoryController::class);
                });

                //InventoryStockAdjustmentController
                Route::group(['middleware' => ['permission:*|all inventory_stock_adjustment|view inventory_stock_adjustment']], function () {
                    Route::patch('/inventorystockadjustment/{id}/approve', [InventoryStockAdjustmentController::class, 'approve'])->name('inventorystockadjustment.approve');
                    Route::resource('inventorystockadjustment', InventoryStockAdjustmentController::class);
                });

                //Warehouse
                Route::group(['middleware' => ['permission:*|all warehouse|view warehouse']], function () {
                    Route::get('/warehouse/sort/{id}', [WarehouseController::class, 'sort'])->name('warehouse.sort');
                    Route::get('/warehouse/edit/{id}', [WarehouseController::class, 'edit'])->name('warehouse.edit');
                    Route::get('/warehouse/publish/{id}', [WarehouseController::class, 'publish'])->name('warehouse.publish');
                    Route::resource('/warehouse', WarehouseController::class);
                });

                //InventoryStockAdjustment
                Route::group(['middleware' => ['permission:*|all inventory_stock_adjustment|view inventory_stock_adjustment']], function () {
                    // Route::get('/inventory_stock_adjustment/import', [InventoryStockAdjustmentController::class, 'inventory_stock_adjustmentimport']);
                    // Route::get('/inventory_stock_adjustment/export', [InventoryStockAdjustmentController::class, 'inventory_stock_adjustmentexport']);
                    // Route::get('/inventory_stock_adjustment/toggle_active/{id}', [InventoryStockAdjustmentController::class, 'toggleActive'])->name('inventory_stock_adjustment.toggle_active');
                    // Route::get('/inventory_stock_adjustment/sort/{id}', [InventoryStockAdjustmentController::class, 'sort'])->name('inventory_stock_adjustment.sort');
                    Route::resource('/inventory_stock_adjustment', InventoryStockAdjustmentController::class);
                });

                //IssueRequisition
                Route::group(['middleware' => ['permission:*|all issue_requisition|view issue_requisition']], function () {
                    Route::get('/issuerequisition/import', [IssueRequisitionController::class, 'issue_requisitionimport']);
                    Route::get('/issuerequisition/export', [IssueRequisitionController::class, 'issue_requisitionexport']);
                    Route::get('/issuerequisition/toggle_active/{id}', [IssueRequisitionController::class, 'toggleActive'])->name('issue_requisition.toggle_active');
                    Route::get('/issuerequisition/sort/{id}', [IssueRequisitionController::class, 'sort'])->name('issue_requisition.sort');
                    Route::resource('/issuerequisition', IssueRequisitionController::class);
                });
                //IssueReturnStock
                Route::group(['middleware' => ['permission:*|all issue_return_stock|view issue_return_stock']], function () {
                    Route::get('/issuereturnstock/import', [IssueReturnStockController::class, 'issue_return_stockimport']);
                    Route::get('/issuereturnstock/export', [IssueReturnStockController::class, 'issue_return_stockexport']);
                    Route::get('/issuereturnstock/toggle_active/{id}', [IssueReturnStockController::class, 'toggleActive'])->name('issue_return_stock.toggle_active');
                    Route::get('/issuereturnstock/sort/{id}', [IssueReturnStockController::class, 'sort'])->name('issue_return_stock.sort');
                    Route::resource('/issuereturnstock', IssueReturnStockController::class);
                });
                //ReceiptPlanning
                Route::group(['middleware' => ['permission:*|all receipt_planning|view receipt_planning']], function () {
                    Route::get('/receiptplanning/import', [ReceiptPlanningController::class, 'receipt_planningimport']);
                    Route::get('/receiptplanning/export', [ReceiptPlanningController::class, 'receipt_planningexport']);
                    Route::get('/receiptplanning/toggle_active/{id}', [ReceiptPlanningController::class, 'toggleActive'])->name('receipt_planning.toggle_active');
                    Route::get('/receiptplanning/sort/{id}', [ReceiptPlanningController::class, 'sort'])->name('receipt_planning.sort');
                    Route::resource('/receiptplanning', ReceiptPlanningController::class);
                });
                //ReceiveFinishStock
                Route::group(['middleware' => ['permission:*|all receive_finish_stock|view receive_finish_stock']], function () {
                    Route::get('/receivefinishstock/import', [ReceiveFinishStockController::class, 'receive_finish_stockimport']);
                    Route::get('/receivefinishstock/export', [ReceiveFinishStockController::class, 'receive_finish_stockexport']);
                    Route::get('/receivefinishstock/toggle_active/{id}', [ReceiveFinishStockController::class, 'toggleActive'])->name('receive_finish_stock.toggle_active');
                    Route::get('/receivefinishstock/sort/{id}', [ReceiveFinishStockController::class, 'sort'])->name('receive_finish_stock.sort');
                    Route::resource('/receivefinishstock', ReceiveFinishStockController::class);
                });
                //ReturnFinishStock
                Route::group(['middleware' => ['permission:*|all return_finish_stock|view return_finish_stock']], function () {
                    Route::get('/returnfinishstock/import', [ReturnFinishStockController::class, 'return_finish_stockimport']);
                    Route::get('/returnfinishstock/export', [ReturnFinishStockController::class, 'return_finish_stockexport']);
                    Route::get('/returnfinishstock/toggle_active/{id}', [ReturnFinishStockController::class, 'toggleActive'])->name('return_finish_stock.toggle_active');
                    Route::get('/returnfinishstock/sort/{id}', [ReturnFinishStockController::class, 'sort'])->name('return_finish_stock.sort');
                    Route::resource('/returnfinishstock', ReturnFinishStockController::class);
                });
                //TransferRequistion
                Route::group(['middleware' => ['permission:*|all transfer_requistion|view transfer_requistion']], function () {
                    Route::get('/transferrequistion/import', [TransferRequistionController::class, 'transfer_requistionimport']);
                    Route::get('/transferrequistion/export', [TransferRequistionController::class, 'transfer_requistionexport']);
                    Route::get('/transferrequistion/toggle_active/{id}', [TransferRequistionController::class, 'toggleActive'])->name('transfer_requistion.toggle_active');
                    Route::get('/transferrequistion/sort/{id}', [TransferRequistionController::class, 'sort'])->name('transfer_requistion.sort');
                    Route::resource('/transferrequistion', TransferRequistionController::class);
                });

                //TransferStock
                Route::group(['middleware' => ['permission:*|all transfer_stock|view transfer_stock']], function () {
                    Route::get('/transferstock/import', [TransferStockController::class, 'transfer_stockimport']);
                    Route::get('/transferstock/export', [TransferStockController::class, 'transfer_stockexport']);
                    Route::get('/transferstock/toggle_active/{id}', [TransferStockController::class, 'toggleActive'])->name('transfer_stock.toggle_active');
                    Route::get('/transferstock/sort/{id}', [TransferStockController::class, 'sort'])->name('transfer_stock.sort');
                    Route::resource('/transferstock', TransferStockController::class);
                });

                //BeginningBalance
                Route::group(['middleware' => ['permission:*|all beginning_balance|view beginning_balance']], function () {
                    Route::get('/beginningbalance/import', [BeginningBalanceController::class, 'beginning_balanceimport']);
                    Route::get('/beginningbalance/export', [BeginningBalanceController::class, 'beginning_balanceexport']);
                    Route::get('/beginningbalance/toggle_active/{id}', [BeginningBalanceController::class, 'toggleActive'])->name('beginning_balance.toggle_active');
                    Route::get('/beginningbalance/sort/{id}', [BeginningBalanceController::class, 'sort'])->name('beginning_balance.sort');
                    Route::resource('/beginningbalance', BeginningBalanceController::class);
                });
                //CountStock
                Route::group(['middleware' => ['permission:*|all count_stock|view count_stock']], function () {
                    Route::get('/countstock/import', [CountStockController::class, 'count_stockimport']);
                    Route::get('/countstock/export', [CountStockController::class, 'count_stockexport']);
                    Route::get('/countstock/toggle_active/{id}', [CountStockController::class, 'toggleActive'])->name('count_stock.toggle_active');
                    Route::get('/countstock/sort/{id}', [CountStockController::class, 'sort'])->name('count_stock.sort');
                    Route::resource('/countstock', CountStockController::class);
                });
            });
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
