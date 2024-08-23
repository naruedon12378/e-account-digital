<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Contact;
use App\Models\TypeBusiness;
use App\Models\CategoryBusiness;
use App\Models\UserPrefix;
use App\Models\Bank;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Contact::all();
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('btn',function ($data){
                    $btnEdit = (Auth::user()->hasAnyPermission(['*', 'all contact', 'edit contact']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`'.url('contact/edit') . '/' . $data['id'].'`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                    $btnDel = (Auth::user()->hasAnyPermission(['*', 'all contact', 'delete contact']) ? '<button class="btn btn-sm btn-danger" onclick="confirmDelete(`'. url('contact/destroy') . '/' . $data['id'].'`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');

                    $btn = $btnEdit . ' ' . $btnDel;

                    return $btn;
                })
                ->addColumn('publish',function ($data){
                    if($data['publish']){
                        $publish = '<label class="switch"> <input type="checkbox" checked value="0" id="' . $data['id'] . '" onchange="publish(`'. url('contact/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }else{
                        $publish = '<label class="switch"> <input type="checkbox" value="1" id="'.$data['id'].'" onchange="publish(`'. url('contact/publish') . '/' . $data['id'].'`)"> <span class="slider round"></span> </label>';
                    }
                    if(Auth::user()->hasRole('user')) {
                        $publish = ($data['publish'] ? '<span class="badge badge-success">เผยแพร่</span>' : '<span class="badge badge-danger">ไม่เผยแพร่</span>');
                    }
                    return $publish;
                })
                ->rawColumns(['btn', 'publish',])
                ->make(true);
        }

        $type_business = TypeBusiness::where('publish',1)->get();
        $categories_business = CategoryBusiness::where('publish',1)->orderBy('sort','DESC')->get();
        $prefixes = UserPrefix::where('status',1)->get();
        $banks = Bank::where('publish',1)->get();
        return view('admin.contact.index',compact('type_business','categories_business','prefixes','banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $status = false;
        $msg = 'ผิดพลาด';

        $config = [
            'table' => 'contacts',
            'field' => 'contact_code',
            'length' => 10,
            'prefix' => 'C' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];

        $contact_code = IdGenerator::generate($config);
        // dd($request);
        $contact = new Contact();
        $contact->contact_code = $contact_code;
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
        $contact->type_company_id = $request->type_company_id;
        $contact->company_id = Auth::user()->company_id;

        if($contact->save()){
            $status = true;
            $msg = 'บันทึกเสร็จสิ้น';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::where('id',$id)->first();

        return response()->json(['contact' => $contact]);
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

        if($contact->save()){
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
        if($contact->delete()){
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
        if($contact->publish == 1) {
            $contact->publish = 0;
        }else{
            $contact->publish = 1;
        }

        if($contact->save()){
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}
