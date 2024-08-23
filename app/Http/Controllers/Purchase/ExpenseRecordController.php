<?php

namespace App\Http\Controllers\Purchase;

use App\Enums\TransactionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRecordRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\ExpenseRecord;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Author: Night
 * Date: 5/6/2024
 * Module: Purchase -> Expense Record
 */
class ExpenseRecordController extends Controller
{
    protected FileUploadService $fileUpload;
    protected PurchaseService $purchase;
    protected readonly string $trxType;
    protected User $user;

    public function __construct(FileUploadService $fileUpload, PurchaseService $purchase)
    {
        $this->fileUpload = $fileUpload;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        $this->purchase = $purchase;
        $this->trxType = TransactionEnum::expense->value;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = dateRange($request->issue_date);
        $fromDate = $date['from'];
        $toDate = $date['to'];

        $status = $request->status ?? 'all';
        $datas = $this->purchase->getAll($request, $this->trxType);
        $tabs = $this->purchase->getStatusTab($datas, $status, $this->trxType);

        if ($request->ajax()) {
            $data = $datas;
            if ($status != 'all')
                $data = $datas->where('status_code', $status);
                
                return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('editLink', function ($data) {
                    return $data->edit_link;
                })
                ->addColumn('action', function ($data) {
                    return $data->btn_action;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_style;
                })
                ->rawColumns(['editLink', 'status','action'])
                ->make(true);
        }

        return view('admin.purchase.expense.index', compact('tabs', 'status', 'fromDate','toDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $purchase = new ExpenseRecord();
        $purchase->doc_number = "EXP000002";

        return view('admin.purchase.expense.create', compact('purchase'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_number' => 'unique:expense_records'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        $this->purchase->save($request, $this->trxType);
        $redirect = route('expenses.index');
        return response()->json($redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = $this->purchase->getOne($id, $this->trxType);
        $items = $this->purchase->getItems($id,$this->trxType);
        $tabs = $this->purchase->getTabs($id,$this->trxType);
        $histories = $this->purchase->getHistory($id,$this->trxType);

        return view('admin.purchase.expense.details', compact('purchase', 'items','tabs', 'histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = $this->purchase->getOne($id, $this->trxType);
        $items = $this->purchase->getItems($id,$this->trxType);
        $tabs = $this->purchase->getTabs($id,$this->trxType);
        $histories = $this->purchase->getHistory($id,$this->trxType);
        
        return view('admin.purchase.expense.create', compact('purchase', 'items','tabs', 'histories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseRequest $request)
    {
        $this->purchase->save($request, $this->trxType);
        $redirect = route('expenses.index');
        return response()->json($redirect);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->purchase->delete($id, $this->trxType);
        $status = true;
        $msg = 'Deleted successfully.';

        return response()->json(['status' => $status, 'msg' => $msg]);
    }
    
}
