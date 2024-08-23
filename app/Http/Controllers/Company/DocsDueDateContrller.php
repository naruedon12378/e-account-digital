<?php

namespace App\Http\Controllers\Company;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingDocType;
use App\Models\SettingDueDate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocsDueDateContrller extends Controller
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
            $company_doc_settings = SettingDueDate::where('company_id', $company_id)->get();
            $doc_types = array(
                1 => __('doc_setting.QO'),
                2 => __('doc_setting.IV'),
                3 => __('doc_setting.BN'),
                4 => __('doc_setting.EXP'),
                5 => __('doc_setting.CPN'),
                6 => __('doc_setting.PA'),
            );

            $formats = array(
                1 => "X วันหลังวันที่ออกเอกสาร",
                2 => "วันที่ X ของเดือนถัดไป",
                3 => "สิ้นเดือนของวันที่ออกเอกสาร",
                4 => "สิ้นเดือนของเดือนถัดไป",
            );

            // $date['year_1'] = $this->Helper->getCurrentYearGregorian();
            // $date['year_2'] = $this->Helper->getCurrentYearThai();
            // $date['year_3'] = $this->Helper->getCurrentYearLastTwoDigitsGregorian();
            // $date['year_4'] = $this->Helper->getCurrentYearLastTwoDigitsThai();
            // $date['month'] = date('m');
            // $date['day'] = date('d');

            $income_docs = [];
            $expense_docs = [];
            foreach ($company_doc_settings as $key => $doc) {
                if ($doc->account_type == 1) {
                    $income_docs[$key]['format_due_date'] = $doc->format_due_date;
                    $income_docs[$key]['length_due_date'] = $doc->length_due_date;
                    $income_docs[$key]['issued_date'] = date('d/m/Y');
                    $current_date = date('Y-m-d');
                    if ($doc->format_due_date == 1) {
                        $income_docs[$key]['due_date'] = date("d/m/Y", strtotime($current_date . "+" . $income_docs[$key]['length_due_date'] . " days"));
                    } else if ($doc->format_due_date == 2) {
                        $income_docs[$key]['due_date'] =
                            date("d/m/Y", strtotime("+1 month", strtotime(date("Y-m-{$income_docs[$key]['length_due_date']}"))));
                    } else if ($doc->format_due_date == 3) {
                        $income_docs[$key]['due_date'] =
                            date("t/m/Y", strtotime($current_date));
                    } else if ($doc->format_due_date == 4) {
                        $firstDayOfNextMonth = date("Y-m-01", strtotime("+1 month", strtotime($current_date)));
                        $lastDayOfNextMonth = date("Y-m-t", strtotime($firstDayOfNextMonth));
                        $income_docs[$key]['due_date'] =
                            date("t/m/Y", strtotime($lastDayOfNextMonth));
                    } else {
                        $income_docs[$key]['due_date'] = null;
                    }
                    if (isset($doc_types[$doc->doc_type])) {
                        $income_docs[$key]['doc_type'] = $doc->doc_type;
                        $income_docs[$key]['doc_type_text'] = $doc_types[$doc->doc_type];
                    }
                    $income_docs[$key]['account_type'] = $doc->account_type;
                } else if ($doc->account_type == 2) {
                    $expense_docs[$key]['format_due_date'] = $doc->format_due_date;
                    $expense_docs[$key]['length_due_date'] = $doc->length_due_date;
                    $expense_docs[$key]['issued_date'] = date('d/m/Y');
                    $current_date = date('Y-m-d');
                    if ($doc->format_due_date == 1) {
                        $expense_docs[$key]['due_date'] = date("d/m/Y", strtotime($current_date . "+" . $expense_docs[$key]['length_due_date'] . " days"));
                    } else if ($doc->format_due_date == 2) {
                        $expense_docs[$key]['due_date'] =
                            date("d/m/Y", strtotime("+1 month", strtotime(date("Y-m-{$expense_docs[$key]['length_due_date']}"))));
                    } else if ($doc->format_due_date == 3) {
                        $expense_docs[$key]['due_date'] =
                            date("t/m/Y", strtotime($current_date));
                    } else if ($doc->format_due_date == 4) {
                        $firstDayOfNextMonth = date("Y-m-01", strtotime("+1 month", strtotime($current_date)));
                        $lastDayOfNextMonth = date("Y-m-t", strtotime($firstDayOfNextMonth));
                        $expense_docs[$key]['due_date'] =
                            date("t/m/Y", strtotime($lastDayOfNextMonth));
                    } else {
                        $expense_docs[$key]['due_date'] = null;
                    }
                    if (isset($doc_types[$doc->doc_type])) {
                        $expense_docs[$key]['doc_type'] = $doc->doc_type;
                        $expense_docs[$key]['doc_type_text'] = $doc_types[$doc->doc_type];
                    }
                    $expense_docs[$key]['account_type'] = $doc->account_type;
                }
            }

            return view('company.doc_setting.due_date.index', compact('income_docs', 'expense_docs', 'company_id'));
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
        // dd($inputData);
        foreach ($inputData as $key => $value) {
            if (preg_match('/_(\d+)$/', $key, $matches)) {
                $group_number = $matches[1];
                $grouped_data[$group_number][$key] = $value;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($grouped_data as $key => $data) {
                $update = SettingDueDate::where([
                    ['company_id', $inputData['company_id']],
                    ['doc_type', $key]
                ])->first();
                $length = 0;
                if (isset($data['length_due_date_' . $key])) {
                    $length = $data['length_due_date_' . $key];
                }
                $update->format_due_date = $data['format_due_date_' . $key];
                $update->length_due_date = $length;
                $update->save();
            }
            DB::commit();
            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('setting-due-date.index');
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
