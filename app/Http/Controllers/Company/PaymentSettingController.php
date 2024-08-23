<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PaymentSettingController extends Controller
{
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $banks = Bank::where('publish', 1)->get()->sortBy('sort');
        if (isset($company_id)) {
            if ($request->ajax()) {
                $data = $data = BankAccount::where('company_id', $company_id)->with('bank')->get();
                return DataTables::make($data)
                    ->addColumn('type', function ($data) {
                        $locale = app()->getLocale();
                        if ($data['financial_type'] == 1) {
                            $type = $locale == 'th' ? 'เงินสด' : 'Cash';
                        } else if ($data['financial_type'] == 2) {
                            $type = $locale == 'th' ? 'ธนาคาร' : 'Bank';
                        } else if ($data['financial_type'] == 3) {
                            $type = $locale == 'th' ? 'สำรองจ่าย' : 'Expense Claim';
                        } else {
                            $type = '-';
                        }
                        return $type;
                    })
                    ->addColumn('name', function ($data) {
                        $locale = app()->getLocale();
                        $acc_type = [
                            '1' => __("payment.account_type1"),
                            '2' => __("payment.account_type2"),
                            '3' => __("payment.account_type3"),
                        ];
                        $account_name = $data['account_name'] == null ? '' : $data['account_name'];

                        if ($data['financial_type'] == 1 || $data['financial_type'] == 3) {
                            $name = $account_name;
                        } else if ($data['financial_type'] == 2) {
                            $account_type = $acc_type[$data['account_type']];
                            $account_number = $data['account_number'] == null ? '' : $data['account_number'];
                            $branch_name = $data['branch_name'] == null ? '' : $data['branch_name'];
                            $branch_code = $data['branch_code'] == null ? '' : $data['branch_code'];
                            $bank_name = $data['bank']['name_' . $locale] . " : " . __('payment.branch_name') . $branch_name . " " . __('payment.branch_code') . ' ' . $branch_code;
                            $name = $account_type . "<br>" . $bank_name . "<br>" . $account_number . '<br>' . $account_name;
                        }
                        return $name;
                    })
                    ->addColumn('remark', function ($data) {
                        $remark = $data['remark'] == null ? '' : $data['remark'];
                        return $remark;
                    })
                    ->addColumn('btn', function ($data) {
                        $btnEdit = (Auth::user()->hasAnyPermission(['*', 'payment_method']) ? '<a class="btn btn-sm btn-warning" onclick="editData(`' . url('setting-payment') . '/edit' . '/' . $data['id']  . '`)"><i class="fa fa-pen" data-toggle="tooltip" title="แก้ไข"></i></a>' : '');
                        $btnDel = (Auth::user()->hasAnyPermission(['*', 'payment_method']) ? '<button class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(`' . url('setting-payment') .  '/destroy' . '/' . $data['id'] . '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i></button>' : '');
                        $btn = $btnEdit . $btnDel;
                        return $btn;
                    })
                    ->rawColumns(['btn', 'name', 'remark', 'type'])
                    ->make(true);
            }
            return view('company.payment_method.index', compact('company_id', 'banks'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $inputData = $request->all();
        DB::beginTransaction();
        try {
            $update = BankAccount::where([
                ['company_id', $inputData['company_id']]
            ])->first()->update($inputData);
            if ($update) {
                DB::commit();
                $status = true;
                $msg = 'บันทึกข้อมูลสำเร็จ';
            }
            return response()->json(['status' => $status, 'msg' => $msg]);
        } catch (\Exception $ex) {
            $result['status'] = "failed";
            $result['message'] = $ex;
            dd($ex);
            DB::rollBack();
            Alert::error('ผิดพลาด');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';
        $save_db = BankAccount::create($data);
        if ($save_db) {
            $status = true;
            $msg = 'บันทึกข้อมูลสำเร็จ';
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BankAccount::whereId($id)->with('bank')->first();
        return response()->json(['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $data_select = BankAccount::whereId($id)->first()->forceDelete();
        if ($data_select) {
            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}
