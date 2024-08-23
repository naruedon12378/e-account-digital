<?php

namespace App\Repositories\WarehouseRepo;

use App\Models\BeginningBalance;
use App\Repositories\Interface\WarehouseInte\BeginningBalanceInterface;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BeginningBalanceRepository implements BeginningBalanceInterface
{
    protected FileUploadService $fileUpload;
    protected string $trxType;

    public function __construct(FileUploadService $fileUpload)
    {
        $this->fileUpload = $fileUpload;
    }
    private function authuser()
    {
        return Auth::user();
    }

    public function index($request)
    {

        $company_id = $this->authuser()->company_id;
        if ($request->issue_date) {
            $date = explodeDate($request->issue_date);
            $fromDate = $date[0];
            $toDate = $date[1];
        } else {
            $fromDate = startingDate();
            $toDate = endingDate();
        }
        $beginningBalances = BeginningBalance::with('company')
            ->where('company_id', $company_id)
            ->where('is_active', 1)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
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
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->format('Y-m-d' . ' H:i A');
                })
                ->addColumn('company_name', function ($data) {
                    if (!empty($data->company))
                        return $data->company->name_en;
                    return null;
                })
                ->rawColumns(['action', 'isActive', 'status', 'blank', 'company_name', 'created_at'])
                ->make(true);
        }
        return view('admin.warehouse.beginningbalance.index', compact('tabs', 'status', 'fromDate', 'toDate'));
    }

    public function getAll($request, $trxType)
    {
    }
}
