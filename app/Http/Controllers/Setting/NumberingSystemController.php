<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Services\NumberingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NumberingSystemController extends Controller
{
    protected NumberingService $numberingService;

    public function __construct(NumberingService $numberingService)
    {
        $this->numberingService = $numberingService;
    }

    public function index()
    {
        $tabs = ['home' => 'Sale Ledger', 'purchase' => 'Purchase Ledger'];
        $_series = Series::where('company_id', 1)->get();
        if (count($_series) == 0) {
            $this->numberingService->setSeries();
            $_series = Series::where('company_id', 1)->get();
        }

        $series = [];
        foreach ($_series as $value) {
            $data['next_number'] = $this->numberingService->getRefNumber($value->transaction_type, false);
            $serie = array_merge($data, $value->toArray());
            $series[$value->transaction_type] = $serie;
        }

        return view('setting.numbering.index', compact('tabs', 'series'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prefix' => 'required|regex:/^[a-zA-Z]+$/u|max:4'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        $series = Series::where([
            ['company_id', 1],
            ['prefix', $request->prefix],
            ['id', '<>', $request->id]
        ])->first();

        if ($series)
            return response()->json(['errors' => 'The prefix ' . $request->prefix . ' already exist !'], 409);

        $data = $request->all();
        $data['month'] = isset($data['month']) ? $data['month'] : 0;
        $data['date'] = isset($data['date']) ? $data['date'] : 0;

        Series::find($request->id)->update($data);
        $ref = $this->numberingService->getRefNumber($request->transaction_type, false);

        return json_encode(['number' => $ref, 'message' => 'Updated ' . $request->transaction_type . ' successfully.']);
    }
    
}
