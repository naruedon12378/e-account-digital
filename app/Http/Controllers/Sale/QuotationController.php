<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Author: Night
 * Date: 3/6/2024
 * Module: Sale -> Quotation
 */

class QuotationController extends Controller
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

        $quotations = Quotation::where('is_active', true)
            ->whereDate('issue_date', '>=', $fromDate)
            ->whereDate('issue_date', '<=', $toDate)
            ->get();

        $status = $request->status ?? 'all';
        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => $quotations->count(), 'color' => 'primary'],
            ['label' => 'Draft', 'value' => 'draft', 'count' => $quotations->where('status_code', 'draft')->count(), 'color' => 'secondary'],
            ['label' => 'Await Approval', 'value' => 'await_approval', 'count' => $quotations->where('status_code', 'await_approval')->count(), 'color' => 'warning'],
            ['label' => 'Await Accept', 'value' => 'await_accept', 'count' => $quotations->where('status_code', 'await_accept')->count(), 'color' => 'primary'],
            ['label' => 'Expired', 'value' => 'expired', 'count' => $quotations->where('status_code', 'expired')->count(), 'color' => 'danger'],
            ['label' => 'Accepted', 'value' => 'accepted', 'count' => $quotations->where('status_code', 'accepted')->count(), 'color' => 'success'],
            ['label' => 'Voided', 'value' => 'voided', 'count' => $quotations->where('status_code', 'voided')->count(), 'color' => 'dark'],
        ];
        $tabs = statusTabs($tabArr, $status);

        if ($request->ajax()) {
            $data = $quotations;
            if ($status != 'all')
                $data = $quotations->where('status_code', $status);

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('editLink', function ($data) {
                    return $data->edit_link;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_style;
                })
                ->rawColumns(['editLink','status'])
                ->make(true);
        }

        return view('admin.revenue.quotation.index', compact('tabs', 'status', 'fromDate','toDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quotation = new Quotation();
        $quotation->reference = "REF000001";
        $quotation->quotation_number = "Q000002";

        return view('admin.revenue.quotation.create', compact('quotation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuotationRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'quotation_number' => 'unique:quotations'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        dd($request->all());

        $data = $request->except('_token', 'items', 'summary');
        $data = $this->summary($request->summary, $data);
        $quotation = Quotation::create($data);
        $this->setItems($request->items, $quotation->id);

        Session::flash('success', 'Created successfully.');
        $redirect = route('quotations.index');

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
        $quotation = Quotation::find($id);
        $items = QuotationItem::where('quotation_id', $id)->get()->toArray();
        $tabs = ['home' => 'Home','history' => 'History'];
        $histories = [
            [
                'user' => 'Night',
                'date' => date('d-m-Y'),
                'time' => '12.05',
                'desc' => 'Saved Draft',
            ],
            [
                'user' => 'Night',
                'date' => date('d-m-Y'),
                'time' => '12.05',
                'desc' => 'Saved Draft',
            ],
            [
                'user' => 'Night',
                'date' => date('d-m-Y'),
                'time' => '12.05',
                'desc' => 'Saved Draft',
            ],
        ];

        return view('admin.revenue.quotation.edit', compact('quotation', 'items', 'tabs', 'histories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuotationRequest $request)
    {
        $data = $request->except('_token', '_method', 'items', 'summary');
        $data = $this->summary($request->summary, $data);
        Quotation::find($request->id)->update($data);
        $this->setItems($request->items, $request->id);

        Session::flash('success', 'Updated successfully.');
        $redirect = route('quotations.index');

        return response()->json($redirect);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Quotation::whereId($id)->update([
            'is_active' => false
        ]);
        $status = true;
        $msg = 'Deleted successfully.';

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    public function getProduct(Request $request)
    {
        $product = Product::where('code', $request->productCode)->first();
        $_product = [
            'code' => $product->code,
            'name' => $product->name_en,
            'product_id' => $product->id,
            'account_code' => '410101',
            'price' => $product->sale_price,
            'discount' => 100,
            'qty' => 1,
            'vat_rate' => 7,
            'wht_rate' => 3,
            'description' => $product->name_en,
            'vat_amt' => 0,
            'wht_amt' => 0,
        ];
        return $_product;
    }

    /**
     * create/update quotation item
     */
    private function setItems($items, $id)
    {
        $items = json_decode($items);
        $oldItemCode = [];
        $oldItems = QuotationItem::where('quotation_id', $id)->get();

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
                    QuotationItem::where([['quotation_id', $id], ['code', $item->code]])->update((array)$item);
                } else {
                    QuotationItem::create((array)$item);
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
