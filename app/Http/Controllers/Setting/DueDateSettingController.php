<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\SettingDueDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DueDateSettingController extends Controller
{
    public function index()
    {
        $tabs = ['home' => 'Sale Ledger', 'purchase' => 'Purchase Ledger'];
        $_duedates = SettingDueDate::where('company_id', 1)->get();
        if (count($_duedates) == 0) {
            $this->setDueDate();
            $_duedates = SettingDueDate::where('company_id', 1)->get();
        }

        $duedates = [];
        foreach ($_duedates as $value) {
            $data['issue_date'] = date('Y-m-d');
            $data['due_date'] = startingDate($value->period);
            $setting = array_merge($data, $value->toArray());
            $duedates[$value->transaction_type] = $setting;
        }

        return view('setting.duedate.index', compact('tabs', 'duedates'));
    }

    private function setDueDate()
    {
        $transactionTypes = ['QO', 'IV', 'BN', 'EXP', 'CPN', 'PA'];
        $data = [
            'format' => 1,
            'period' => 0,
            'company_id' => 1,
            'created_by' => 's',
        ];
        foreach ($transactionTypes as $value) {
            $data['transaction_type'] = $value;
            SettingDueDate::create($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'prefix' => 'required|regex:/^[a-zA-Z]+$/u|max:4'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 409);
        // }

        $ids = $request->id;
        $formats = $request->format;
        $periods = $request->period;

        for ($i=0; $i < count($ids); $i++) { 
            $_setting['format'] = $formats[$i];
            $_setting['period'] = $periods[$i];

            SettingDueDate::where([
                ['company_id', 1],
                ['id', $ids[$i]]
                ])->update($_setting);
        }
        
        return json_encode(['message' => 'Update successfully.']);
    }


}
