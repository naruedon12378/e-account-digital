<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Author: Night
 * Date: 3/6/2024
 * Module: Sale -> Sale Invoice
 */
class SaleInvoiceController extends Controller
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
        if ($request->issue_date) {
            $date = explodeDate($request->issue_date);
            $fromDate = $date[0];
            $toDate = $date[1];
        } else {
            $fromDate = startingDate();
            $toDate = endingDate();
        }

        $invoices = Invoice::where('is_active', true)
            ->whereDate('issue_date', '>=', $fromDate)
            ->whereDate('issue_date', '<=', $toDate)
            ->get();

        $status = $request->status ?? 'all';
        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => $invoices->count(), 'color' => 'primary'],
            ['label' => 'Draft', 'value' => 'draft', 'count' => $invoices->where('status_code', 'draft')->count(), 'color' => 'secondary'],
            ['label' => 'Await Approval', 'value' => 'await_approval', 'count' => $invoices->where('status_code', 'await_approval')->count(), 'color' => 'warning'],
            ['label' => 'Outstanding', 'value' => 'outstanding', 'count' => $invoices->where('status_code', 'outstanding')->count(), 'color' => 'primary'],
            ['label' => 'Overdue', 'value' => 'overdue', 'count' => $invoices->where('status_code', 'overdue')->count(), 'color' => 'danger'],
            ['label' => 'Paid', 'value' => 'paid', 'count' => $invoices->where('status_code', 'paid')->count(), 'color' => 'success'],
            ['label' => 'Voided', 'value' => 'voided', 'count' => $invoices->where('status_code', 'voided')->count(), 'color' => 'dark'],
            ['label' => 'Recurring', 'value' => 'recurring', 'count' => $invoices->where('status_code', 'recurring')->count(), 'color' => 'dark'],
        ];
        $tabs = statusTabs($tabArr, $status);

        if ($request->ajax()) {
            $data = $invoices;
            if ($status != 'all')
                $data = $invoices->where('status_code', $status);
                
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_style;
                })
                ->rawColumns(['action', 'isActive', 'status'])
                ->make(true);
        }

        return view('admin.revenue.invoice.index', compact('tabs', 'status', 'fromDate','toDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoice = new Invoice();
        $invoice->reference = "RF000001";
        $invoice->doc_number = "IV000001";
        return view('admin.revenue.invoice.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_number' => 'unique:invoices'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        $data = $request->except('_token', 'items', 'summary');
        $data = $this->summary($request->summary, $data);
        $invoice = Invoice::create($data);
        $this->setItems($request->items, $invoice->id);
        
        Session::flash('success', 'Created successfully.');
        $redirect = route('invoices.index');

        return response()->json($redirect);
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
        $invoice = Invoice::find($id);
        $items = InvoiceItem::where('invoice_id', $id)->get()->toArray();

        return view('admin.revenue.invoice.create', compact('invoice', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_method', 'items', 'summary');
        $data = $this->summary($request->summary, $data);
        Invoice::find($request->id)->update($data);
        $this->setItems($request->items, $request->id);

        Session::flash('success', 'Updated successfully.');
        $redirect = route('invoices.index');

        return response()->json($redirect);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Invoice::whereId($id)->update([
            'is_active' => false
        ]);
        $status = true;
        $msg = 'Deleted successfully.';

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * create/update quotation item
     */
    private function setItems($items, $id)
    {
        $items = json_decode($items);
        $oldItemCode = [];
        $oldItems = InvoiceItem::where('invoice_id', $id)->get();

        if (count($oldItems) > 0) {
            $codes = [];

            foreach ($items as $item) {
                array_push($codes, $item->code);
            }

            foreach ($oldItems as $item) {
                $oldItemCode[] = $item->code;

                if (!in_array($item->code, $codes)) {
                    $item->delete();
                }
            }
        }

        if (count($items)) {
            foreach ($items as $item) {
                $item->quotation_id = $id;
                if (in_array($item->code, $oldItemCode)) {
                    InvoiceItem::where([['invoice_id', $id], ['code', $item->code]])->update((array)$item);
                } else {
                    InvoiceItem::create((array)$item);
                }
            }
        }
    }

    /**
     * merge summary and data
     */
    private function summary($summary, $data)
    {
        $summary = (array)json_decode($summary);
        $data = array_merge($data, $summary);
        $data['created_by'] = $this->user->firstname;
        $data['company_id'] = 1;

        return $data;
    }
}
