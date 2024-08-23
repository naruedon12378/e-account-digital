<?php

namespace App\Http\Controllers\Company;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingDocType;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocsRemarkController extends Controller
{
    private $Helper;
    public function __construct()
    {
        $this->Helper = new UniversalHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $company_id = Company::where('user_id', Auth::user()->id)->pluck('id')->first();
        $company_id = Auth::user()->company_id;

        if (isset($company_id)) {
            $company_doc_settings = SettingDocType::where('company_id', $company_id)->get();
            $doc_types = array(
                0 => __('doc_setting.QO'),
                1 => __('doc_setting.TDN'),
                2 => __('doc_setting.IV'),
                3 => __('doc_setting.IVT'),
                4 => __('doc_setting.DN'),
                5 => __('doc_setting.RE'),
                6 => __('doc_setting.RT'),
                7 => __('doc_setting.TIV'),
                8 => __('doc_setting.CN'),
                9 => __('doc_setting.CNT'),
                10 => __('doc_setting.BN'),
                11 => __('doc_setting.DBN'),
                12 => __('doc_setting.DBNT'),
                13 => __('doc_setting.PO'),
                14 => __('doc_setting.POA'),
                15 => __('doc_setting.PR'),
                16 => __('doc_setting.EXP'),
                17 => __('doc_setting.CNX'),
                18 => __('doc_setting.CPN'),
                19 => __('doc_setting.PA'),
            );

            $date['year_1'] = $this->Helper->getCurrentYearGregorian();
            $date['year_2'] = $this->Helper->getCurrentYearThai();
            $date['year_3'] = $this->Helper->getCurrentYearLastTwoDigitsGregorian();
            $date['year_4'] = $this->Helper->getCurrentYearLastTwoDigitsThai();
            $date['month'] = date('m');
            $date['day'] = date('d');

            $income_docs = [];
            $expense_docs = [];
            foreach ($company_doc_settings as $key => $doc) {
                if ($doc->account_type == 1) {
                    $income_docs[$key]['remark'] = $doc->remark;
                    if (isset($doc_types[$doc->doc_type - 1])) {
                        $income_docs[$key]['doc_type'] = $doc->doc_type;
                        $income_docs[$key]['doc_type_text'] = $doc_types[$doc->doc_type - 1];
                    }
                    $income_docs[$key]['account_type'] = $doc->account_type;
                } else if ($doc->account_type == 2) {
                    $expense_docs[$key]['remark'] = $doc->remark;
                    if (isset($doc_types[$doc->doc_type - 1])) {
                        $expense_docs[$key]['doc_type'] = $doc->doc_type;
                        $expense_docs[$key]['doc_type_text'] = $doc_types[$doc->doc_type - 1];
                    }
                    $expense_docs[$key]['account_type'] = $doc->account_type;
                }
            }

            return view('company.doc_setting.remark.index', compact('income_docs', 'expense_docs', 'date', 'company_id'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputData = $request->all();
        $grouped_data = [];
        foreach ($inputData as $key => $value) {
            if (preg_match('/_(\d+)$/', $key, $matches)) {
                $group_number = $matches[1];
                $grouped_data[$group_number][$key] = $value;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($grouped_data as $key => $data) {
                $update = SettingDocType::where([
                    ['company_id', $inputData['company_id']],
                    ['doc_type', $key]
                ])->first();
                $update->remark = $data['remark_' . $key];
                $update->save();
            }
            DB::commit();
            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('setting-remark.index');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
