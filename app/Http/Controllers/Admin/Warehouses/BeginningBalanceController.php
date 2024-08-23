<?php

namespace App\Http\Controllers\Admin\Warehouses;

use App\Http\Controllers\Controller;
use App\Http\Requests\warehouse\BeginningBalanceRequest;
use App\Models\BeginningBalance;
use App\Models\BeginningBalanceItem;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\Inventory;
use App\Models\InventoryStock;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\Warehouse\BeginningBalanceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BeginningBalanceController extends Controller
{
    protected FileUploadService $fileUpload;

    protected BeginningBalanceService $beginningBalance;
    protected User $user;
    private $company_id;
    public function __construct(FileUploadService $fileUpload, BeginningBalanceService $beginningBalance)
    {
        $this->fileUpload = $fileUpload;
        $this->beginningBalance = $beginningBalance;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->company_id = Auth::user()->company_id;
            return $next($request);
        });
    }
    public function indexWITHREPO(Request $request)
    {
        return $this->beginningBalance->index($request);
    }
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
        $beginningBalances = BeginningBalance::with('company')
            ->where('company_id', $this->company_id)
            ->where('is_active', 1)
            ->whereDate('created_date', '>=', $fromDate)
            ->whereDate('created_date', '<=', $toDate)
            ->orderBy('created_at', 'desc')
            ->get();
        $status = $request->status ?? 'all';
        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => $beginningBalances->count(), 'color' => 'primary'],
            ['label' => 'Pending', 'value' => 'pending', 'count' => $beginningBalances->where('status', 'pending')->count(), 'color' => 'warning'],
            ['label' => 'Approved', 'value' => 'approved', 'count' => $beginningBalances->where('status', 'approved')->count(), 'color' => 'success'],
            ['label' => 'Transferring', 'value' => 'transferring', 'count' => $beginningBalances->where('status', 'transferring')->count(), 'color' => 'info'],
            ['label' => 'Transferred', 'value' => 'transferred', 'count' => $beginningBalances->where('status', 'transferred')->count(), 'color' => 'success'],
            ['label' => 'Rejected', 'value' => 'reject', 'count' => $beginningBalances->where('status', 'reject')->count(), 'color' => 'danger'],
        ];
        $tabs = statusTabs($tabArr, $status);
        if ($request->ajax()) {
            $data = $beginningBalances;
            if ($status != 'all')
                $data = $data->where('status', $status);
            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btn_edit;
                    // return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_style;
                })
                ->addColumn('blank', function ($data) {
                    return $data->blank_id;
                })
                ->addColumn('company_address', function ($data) {
                    if (!empty($data->company) && !empty($data->company->company_address))
                        return $data->company->company_address->sub_district_en . ' ' . $data->company->company_address->district_en . ' ' . $data->company->company_address->province_en . ' , ' . $data->company->company_address->postcode;
                    return null;
                })
                ->addColumn('created_date', function ($data) {
                    return $data->created_date;
                })
                ->addColumn('company_name', function ($data) {
                    if (!empty($data->company))
                        return $data->company->name_en;
                    return null;
                })
                ->rawColumns(['action', 'isActive', 'status', 'blank', 'company_name', 'created_date'])
                ->make(true);
        }
        return view('admin.warehouse.beginningbalance.index', compact('tabs', 'status', 'fromDate', 'toDate'));
    }
    public function create()
    {
        $status = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'transferring' => 'Transferring',
            'transferred' => 'Transferred',
            'reject' => 'Rejected',
        ];
        $companies = Company::where('id', $this->company_id)->get();
        $branch = Branch::where('company_id', $this->company_id)->get();
        $beginningBalance = new BeginningBalance();
        $beginningBalance_code = $beginningBalance::pluck('code')->toArray();
        $beginningBalance->code = generateUniqueCode('BEG-', $beginningBalance_code);
        return view('admin.warehouse.beginningbalance.create', compact('beginningBalance', 'companies', 'branch', 'status'));
    }
    public function store(BeginningBalanceRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_number' => 'unique:invoices',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }
        $data = $request->except('_token', 'items', 'summary');
        $summary = (array) json_decode($request->summary);
        $data = $this->summary($request->summary, $data);
        $branch_id = Company::where('id', $data['company_id'])->first()->branch_id;
        $beginningBalance = BeginningBalance::create([
            'company_id' => $data['company_id'],
            'code' => $data['code'],
            'created_date' => $data['created_date'],
            'title' => "Beginning Balance For " . $data['code'],
            'branch_id' => $branch_id,
            'total_price' => $summary['grand_total'],
            'remark' => $data['remark'],
            'user_creator_id' => $data['user_creator_id'],
            'user_checker_id' => $data['user_checker_id'],
            'user_approver_id' => $data['user_approver_id'],
            'user_receiver_id' => $data['user_receiver_id'],
            'status' => $data['status'],
            'currency_code' => $data['currency_code'],
            'tax_type' => $data['tax_type'],
            'created_by' => $data['user_creator_id'],

        ]);
        $this->setItems($request->items, $beginningBalance->id, $beginningBalance->company_id);
        Session::flash('success', 'Created successfully.');
        $redirect = route('beginningbalance.index');
        return response()->json($redirect);
    }
    public function show(Request $request)
    {
    }
    public function edit(string $id)
    {
        $status = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'transferring' => 'Transferring',
            'transferred' => 'Transferred',
            'reject' => 'Rejected',
        ];
        $beginningBalance = BeginningBalance::find($id);
        $items = BeginningBalanceItem::where('beginning_balance_id', $id)->get()->toArray();
        $companies = Company::where('id', $this->company_id)->get();
        $branch = Branch::where('company_id', $this->company_id)->get();
        return view('admin.warehouse.beginningbalance.create', compact('beginningBalance', 'items', 'companies', 'branch', 'status'));
    }
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', '_method', 'items', 'summary');
        $summary = (array) json_decode($request->summary);
        $data = $this->summary($request->summary, $data);
        BeginningBalance::find($request->id)->update([
            'code' => $data['code'],
            'tax_type' => $data['tax_type'],
            'created_date' => $data['created_date'],
            'currency_code' => $data['currency_code'],
            'title' => $data['title'],
            'branch_id' => $data['branch_id'],
            'total_price' => $summary['grand_total'],
            'remark' => $data['remark'],
            'status' => $data['status'],
            'user_creator_id' => $data['user_creator_id'],
            'user_checker_id' => $data['user_checker_id'],
            'user_approver_id' => $data['user_approver_id'],
            'user_receiver_id' => $data['user_receiver_id'],
            'updated_by' => $data['user_creator_id'],
            'company_id' => $data['company_id'],
        ]);
        $this->setItems($request->items, $request->id, $request->company_id);
        Session::flash('success', 'Updated successfully.');
        $redirect = route('beginningbalance.index');
        return response()->json($redirect);
    }
    public function destroy(string $id)
    {
        BeginningBalance::whereId($id)->update([
            'is_active' => 0,
            'deleted_by' => auth()->user()->id ?? null,
            'deleted_at' => Carbon::now()
        ]);
        $status = true;
        $msg = 'Deleted successfully.';
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
    public function inventoryimport(Request $request)
    {
    }
    public function inventoryexport(Request $request)
    {
    }
    public function sort(Request $request)
    {
    }
    public function toggleActive(Request $request, string $id)
    {

        $beginningBalance = BeginningBalance::find($id);
        if ($beginningBalance->is_active == 1) {
            $beginningBalance->is_active = 0;
        }
        if ($beginningBalance->is_active == 0) {
            $beginningBalance->is_active = 1;
        }
        $beginningBalance->save();
        return response()->json(['status' => true]);
    }

    private function summary($summary, $data)
    {
        if (isset($data['company_id'])) {
            $company_id = $data['company_id'];
            $data['company_id'] = $company_id;
            $company_name = Company::where('id', $company_id)->pluck('name_en')->first();
            $branch_id = Branch::where('company_id', $company_id)->pluck('id')->first();
            $data['branch_id'] = $branch_id;
        } else {
            $company_name = null;
            $data['branch_id'] = 1;
            $data['company_id'] = 1;
        }
        $summary = (array) json_decode($summary);
        // $data = array_merge($data, $summary);
        $data['user_creator_id'] = $this->user->id;
        $data['user_checker_id'] = $this->user->id;
        $data['user_approver_id'] = $this->user->id;
        $data['user_receiver_id'] = $this->user->id;
        $data['total_price'] = $summary['grand_total'];
        $data['title'] = 'Beginning Balance For' . $company_name;
        $data['created_by'] = $this->user->firstname . ' ' . $this->user->lastname;
        return $data;
    }
    private function setItems($items, $id, $company_id)
    {

        $items = json_decode($items);
        $oldItemCode = [];
        $oldItems = BeginningBalanceItem::where('beginning_balance_id', $id)->get();
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
                $prodcut_id = $item->product_id;
                $inventory_id = Inventory::where('product_id', $prodcut_id)->pluck('id')->first();
                if ($inventory_id == null) {
                    $inventory_id = 1;
                }
                $inventory_stock_id = InventoryStock::where('inventory_id', $inventory_id)->pluck('id')->first();
                if ($inventory_stock_id == null) {
                    $inventory_stock_id = 1;
                }
                $companyData = CompanyAddress::where('company_id', $company_id)->first();
                if ($companyData) {
                    $location = $companyData->sub_district_en . ' ' . $companyData->district_en . ' ' . $companyData->province_en . ', ' . $companyData->postcode;
                } else {
                    $location = '';
                }
                $item->beginning_balance_id = $id;
                $item->inventory_stock_id = $inventory_stock_id;
                $item->created_by = $this->user->firstname . ' ' . $this->user->lastname;
                $item->quotation_id = $id;
                if (in_array($item->code, $oldItemCode)) {
                    BeginningBalanceItem::where([['beginning_balance_id', $id], ['code', $item->code]])->update([
                        'beginning_balance_id' => $id,
                        'product_id' => $item->product_id,
                        'inventory_stock_id' => $inventory_stock_id,
                        'line_item_no' => $item->line_item_no,
                        'code' => $item->code,
                        'name' => $item->name,
                        'account_code' => $item->account_code,
                        'location' => $location,
                        'amount' => $item->qty,
                        'discount' => $item->discount,
                        'qty' => $item->qty,
                        'vat_rate' => $item->vat_rate,
                        'vat_amt' => $item->vat_amt,
                        'wht_rate' => $item->wht_rate,
                        'wht_amt' => $item->wht_amt,
                        'total_price' => $item->pre_vat_amt,
                        'cost_price' => $item->price,
                        // 'remark' => $item->remark,
                        'created_by' => $item->created_by,
                        'updated_by' => $this->user->firstname . ' ' . $this->user->lastname,
                    ]);
                } else {
                    BeginningBalanceItem::create([
                        'beginning_balance_id' => $id,
                        'product_id' => $item->product_id,
                        'inventory_stock_id' => $inventory_stock_id,
                        'line_item_no' => $item->line_item_no,
                        'code' => $item->code,
                        'name' => $item->name,
                        'account_code' => $item->account_code,
                        'location' => $location,
                        'amount' => $item->qty,
                        'discount' => $item->discount,
                        'qty' => $item->qty,
                        'vat_rate' => $item->vat_rate,
                        'vat_amt' => $item->vat_amt,
                        'wht_rate' => $item->wht_rate,
                        'wht_amt' => $item->wht_amt,
                        'total_price' => $item->pre_vat_amt,
                        'cost_price' => $item->price,
                        'remark' => $item->description,
                        'created_by' => $item->created_by,
                        'updated_by' => $this->user->firstname . ' ' . $this->user->lastname,
                    ]);
                }
            }
        }
    }
}
