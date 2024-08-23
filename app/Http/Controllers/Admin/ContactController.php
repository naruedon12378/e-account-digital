<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\FileUploadService;
use App\Models\Contact;
use App\Models\ContactBank;
use App\Models\ContactPerson;
use App\Models\OfficeAddress;
use App\Models\User;
use App\Models\RegisteredAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Yajra\DataTables\Facades\DataTables;


class ContactController extends Controller
{
    protected FileUploadService $fileUpload;
    protected User $user;

    public function __construct(FileUploadService $fileUpload)
    {
        $this->fileUpload = $fileUpload;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contacts = Contact::active()->get();
        $status = $request->status ?? 'all';

        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => $contacts->where('party_type', 'all')->count(), 'class' => 'active', 'color' => 'primary'],
            ['label' => 'Customer', 'value' => 'customer', 'count' => $contacts->where('party_type', 'customer')->count(), 'color' => 'success'],
            ['label' => 'Seller', 'value' => 'seller', 'count' => $contacts->where('party_type', 'seller')->count(), 'color' => 'warning'],
            ['label' => 'Disable', 'value' => 'disable', 'count' => $contacts->where('party_type', 'disable')->count(), 'color' => 'secondary'],
        ];
        $tabs = statusTabs($tabArr, $status);

        if ($request->ajax()) {
            $data = $contacts->where('party_type', $status);
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('partyName', function ($data) {
                    return $data->party_name;
                })
                ->addColumn('showLink', function ($data) {
                    return $data->show_link;
                })
                ->addColumn('action', function ($data) {
                    return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['editLink', 'action', 'isActive'])
                ->make(true);
        }

        return view('admin.contact.index', compact('tabs'));
    }

    /**
     * create
     */
    public function create()
    {
        $contact = new Contact();
        return view('admin.contact.create', compact('contact'));
    }

    /**
     * store
     */
    public function store(ContactRequest $request)
    {

        $status = false;
        $msg = 'ผิดพลาด';

        $config = [
            'table' => 'contacts',
            'field' => 'code',
            'length' => 10,
            'prefix' => 'C' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];
        // dd($request->all());
        $code = IdGenerator::generate($config);
        $contact = Contact::create([
            'code' => $code,
            'region' => $request->type_registration ?? '',
            'tax_id' => $request->tax_id ?? '',
            'branch' => $request->branch ?? '',
            'party_type' => $request->check_type_contact ?? '',
            'business_type_id' => $request->category_id ?? '',
            'prefix' => $request->prefix ?? '',
            'first_name' => $request->first_name ?? '',
            'last_name' => $request->last_name ?? '',
            'company_name' => $request->company_name ?? '',
            'email' => $request->email ?? '',
            'phone' => $request->phone ?? '',
            'website'  => $request->website ?? '',
            'fax' => $request->fax_number ?? '',
            'sale_credit_term_id' => '1',
            'purchase_credit_term_id' => '1',
            'sale_account_id' => '1',
            'purchase_account_id' => '1',
            'credit_limit_type' => '1',
            'credit_limit_amt' => '1',
            // 'sale_credit_term_id' => $request->sale_credit_term_id ?? '',
            // 'purchase_credit_term_id' => $request->purchase_credit_term_id ?? '',
            // 'sale_account_id' => $request->sale_account_id ?? '',
            // 'purchase_account_id' => $request->purchase_account_id ?? '',
            // 'credit_limit_type' => $request->credit_limit_type ?? '',
            // 'credit_limit_amt' => $request->credit_limit_amt ?? '',
            'company_id' =>  $request->type_company_id ?? '',
            'created_by' => $this->user->firstname,
        ]);
        if ($contact) {
            ContactBank::create([
                'contact_id' => $contact->id,
                'bank_id' => $request->bank_id ?? '',
                'account_name' => $request->bank_account ?? '',
                'account_number' => $request->bank_number ?? '',
                'branch name' => $request->bank_branch ?? '',
            ]);
            ContactPerson::create([
                'contact_id' => $contact->id,
                'prefix' => $request->prefix_id ?? '',
                'first_name' => $request->first_name ?? '',
                'last_name'   => $request->last_name ?? '',
                'nick_name' => $request->name ?? '',
                'email' => $request->email ?? '',
                'phone' => $request->tel_phone ?? '',
                'position' => $request->position ?? '',
                'department' => $request->department ?? '',
            ]);
            OfficeAddress::create([
                'contact_id' => $contact->id,
                'contact_name' => $request->contact_name ?? '',
                'address' => $request->contact_address ?? '',
                'province_id' => '1',
                'amphure_id' => '1',
                'district_id' => '1',
                'postcode' => '1',
                // 'province_id' => $request->contact_province ?? '',
                // 'amphure_id' => $request->contact_sub_district ?? '',
                // 'district_id' => $request->contact_district ?? '',
                // 'postcode' => $request->contact_post_code ?? '',
            ]);
            RegisteredAddress::create([
                'contact_id' => $contact->id,
                'contact_name' => $request->contact_name ?? '',
                'address' => $request->contact_address ?? '',
                'province_id' => '1',
                'amphure_id' => '1',
                'district_id' => '1',
                'postcode' => '1',
                // 'province_id' => $request->contact_province ?? '',
                // 'amphure_id' => $request->contact_sub_district ?? '',
                // 'district_id' => $request->contact_district ?? '',
                // 'postcode' => $request->contact_post_code ?? '',
            ]);
        }

        Session::flash('success', 'Created successfully');
        $redirect = route('contacts.index');
        return redirect($redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = new Contact();
        $contact->id = 1;
        $contact->company_name = "saw aung naing oo";
        $contact->business_type = 'Limited Partnership';

        $tabs = ['home' => 'Home','overview' => 'Overview', 'contactPerson' => 'Contact Person'];

        return view('admin.contact.details', compact('contact', 'tabs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::find($id);

        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $contact = Contact::whereId($request->id)->first();
        $contact->contact_code = $request->contact_code;
        $contact->check_type_contact = $request->check_type_contact;
        $contact->registration_number = $request->registration_number;
        $contact->branch_type = $request->branch_type;
        $contact->branch_code = $request->branch_code;
        $contact->type_registration = $request->type_registration;
        $contact->category_id = $request->category_id;
        $contact->company_name = $request->company_name;
        $contact->prefix_id = $request->prefix_id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->sub_district = $request->sub_district;
        $contact->province = $request->province;
        $contact->post_code = $request->post_code;
        $contact->email = $request->email;
        $contact->tel_phone = $request->tel_phone;
        $contact->website = $request->website;
        $contact->fax_number = $request->fax_number;
        $contact->contact_name = $request->contact_name;
        $contact->contact_address = $request->contact_address;
        $contact->contact_sub_district = $request->contact_sub_district;
        $contact->contact_district = $request->contact_district;
        $contact->contact_province = $request->contact_province;
        $contact->contact_post_code = $request->contact_post_code;
        $contact->contact_info_prefix_id = $request->contact_info_prefix_id;
        $contact->contact_info_first_name = $request->contact_info_first_name;
        $contact->contact_info_last_name = $request->contact_info_last_name;
        $contact->contact_info_nickname = $request->contact_info_nickname;
        $contact->contact_info_email = $request->contact_info_email;
        $contact->contact_info_tel_phone = $request->contact_info_tel_phone;
        $contact->contact_info_position = $request->contact_info_position;
        $contact->contact_info_branch = $request->contact_info_branch;
        $contact->bank_id = $request->bank_id;
        $contact->bank_account = $request->bank_account;
        $contact->bank_number = $request->bank_number;
        $contact->bank_branch = $request->bank_branch;
        $contact->invoice_payment_status = $request->invoice_payment_status;
        $contact->invoice_date_length = $request->invoice_date_length;
        $contact->expense_payment_status = $request->expense_payment_status;
        $contact->expense_date_length = $request->expense_date_length;
        $contact->set_budget = $request->set_budget;
        $contact->limit_price = $request->limit_price;

        if ($contact->save()) {
            $status = true;
            $msg = 'บันทึกเสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $contact = Contact::whereId($id)->first();
        if ($contact->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function publish(string $id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $contact = Contact::whereId($id)->first();
        if ($contact->publish == 1) {
            $contact->publish = 0;
        } else {
            $contact->publish = 1;
        }

        if ($contact->save()) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}
