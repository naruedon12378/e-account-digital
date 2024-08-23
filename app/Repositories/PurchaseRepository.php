<?php

namespace App\Repositories;

use App\Enums\TransactionEnum;
use App\Models\ExpenseRecord;
use App\Models\ExpenseRecordItem;
use App\Models\PurchaseAssetInvoice;
use App\Models\PurchaseAssetInvoiceItem;
use App\Models\PurchaseAssetOrder;
use App\Models\PurchaseAssetOrderItem;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Services\FileUploadService;
use App\Repositories\Interface\PurchaseInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseRepository implements PurchaseInterface
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

    public function getAll($request, $trxType)
    {
        $date = dateRange($request->issue_date);
        $fromDate = $date['from'];
        $toDate = $date['to'];

        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
                $datas = PurchaseOrder::where('is_active', true)
                    ->whereDate('issue_date', '>=', $fromDate)
                    ->whereDate('issue_date', '<=', $toDate)
                    ->get();
                break;
            case TransactionEnum::purchaseInvoice->value:
                $datas = PurchaseInvoice::where('is_active', true)
                    ->whereDate('issue_date', '>=', $fromDate)
                    ->whereDate('issue_date', '<=', $toDate)
                    ->get();
                break;
            case TransactionEnum::expense->value:
                $datas = ExpenseRecord::where('is_active', true)
                    ->whereDate('issue_date', '>=', $fromDate)
                    ->whereDate('issue_date', '<=', $toDate)
                    ->get();
                break;
            case TransactionEnum::poAsset->value:
                $datas = PurchaseAssetOrder::where('is_active', true)
                    ->whereDate('issue_date', '>=', $fromDate)
                    ->whereDate('issue_date', '<=', $toDate)
                    ->get();
                break;
            case TransactionEnum::purchaseAsset->value:
                $datas = PurchaseAssetInvoice::where('is_active', true)
                    ->whereDate('issue_date', '>=', $fromDate)
                    ->whereDate('issue_date', '<=', $toDate)
                    ->get();
                break;
            default:
                break;
        }
        return $datas;
    }

    public function getStatusTab($datas, $status, $trxType)
    {
        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
            case TransactionEnum::poAsset->value:
                $tabArr = [
                    ['label' => 'All', 'value' => 'all', 'count' => $datas->count(), 'color' => 'primary'],
                    ['label' => 'Draft', 'value' => 'draft', 'count' => $datas->where('status_code', 'draft')->count(), 'color' => 'secondary'],
                    ['label' => 'Await Approval', 'value' => 'await_approval', 'count' => $datas->where('status_code', 'await_approval')->count(), 'color' => 'warning'],
                    ['label' => 'Approved', 'value' => 'approved', 'count' => $datas->where('status_code', 'approved')->count(), 'color' => 'success'],
                    ['label' => 'Voided', 'value' => 'voided', 'count' => $datas->where('status_code', 'voided')->count(), 'color' => 'dark'],
                ];
                break;
            case TransactionEnum::purchaseInvoice->value:
            case TransactionEnum::expense->value:
            case TransactionEnum::purchaseAsset->value:
                $tabArr = [
                    ['label' => 'All', 'value' => 'all', 'count' => $datas->count(), 'color' => 'primary'],
                    ['label' => 'Draft', 'value' => 'draft', 'count' => $datas->where('status_code', 'draft')->count(), 'color' => 'secondary'],
                    ['label' => 'Await Approval', 'value' => 'await_approval', 'count' => $datas->where('status_code', 'await_approval')->count(), 'color' => 'warning'],
                    ['label' => 'Outstanding', 'value' => 'outstanding', 'count' => $datas->where('status_code', 'outstanding')->count(), 'color' => 'primary'],
                    ['label' => 'Overdue', 'value' => 'overdue', 'count' => $datas->where('status_code', 'overdue')->count(), 'color' => 'danger'],
                    ['label' => 'Await Receipt', 'value' => 'await_receipt', 'count' => $datas->where('status_code', 'await_receipt')->count(), 'color' => 'warning'],
                    ['label' => 'Got Receipt', 'value' => 'got_receipt', 'count' => $datas->where('status_code', 'got_receipt')->count(), 'color' => 'success'],
                    ['label' => 'Voided', 'value' => 'voided', 'count' => $datas->where('status_code', 'voided')->count(), 'color' => 'dark'],
                    ['label' => 'Recurring', 'value' => 'recurring', 'count' => $datas->where('status_code', 'recurring')->count(), 'color' => 'dark'],
                ];
                break;
            default:
                break;
        }
        return statusTabs($tabArr, $status);
    }

    public function save($request, $trxType)
    {
        $data = $request->except('_token', 'summary', 'items');
        $data = $this->summary($request->summary, $data);
        $id = $request->id;
        Session::flash('success', $id ? 'Updated' : 'Created' . ' successfully.');

        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
                $id = $this->setPurchaseOrder($data, $id);
                break;
            case TransactionEnum::purchaseInvoice->value:
                $id = $this->setPurchaseInvoice($data, $id);
                break;
            case TransactionEnum::expense->value:
                $id = $this->setExpense($data, $id);
                break;
            case TransactionEnum::poAsset->value:
                $id = $this->setAssetOrder($data, $id);
                break;
            case TransactionEnum::purchaseAsset->value:
                $id = $this->setAssetInvoice($data, $id);
                break;
            default:
                break;
        }
        $this->trxType = $trxType;
        $this->setItems($request->items, $id);
    }

    private function setPurchaseOrder($data, $id)
    {
        if ($id) {
            PurchaseOrder::find($id)->update($data);
        } else {
            $purchase = PurchaseOrder::create($data);
            $id = $purchase->id;
        }
        return $id;
    }

    private function setPurchaseInvoice($data, $id)
    {
        if ($id) {
            PurchaseOrder::find($id)->update($data);
        } else {
            $purchase = PurchaseOrder::create($data);
            $id = $purchase->id;
        }
        return $id;
    }

    private function setExpense($data, $id)
    {
        if ($id) {
            ExpenseRecord::find($id)->update($data);
        } else {
            $purchase = ExpenseRecord::create($data);
            $id = $purchase->id;
        }
        return $id;
    }

    private function setAssetOrder($data, $id)
    {
        if ($id) {
            PurchaseAssetOrder::find($id)->update($data);
        } else {
            $purchase = PurchaseAssetOrder::create($data);
            $id = $purchase->id;
        }
        return $id;
    }

    private function setAssetInvoice($data, $id)
    {
        if ($id) {
            PurchaseAssetInvoice::find($id)->update($data);
        } else {
            $purchase = PurchaseAssetInvoice::create($data);
            $id = $purchase->id;
        }
        return $id;
    }

    public function getOne($id, $trxType)
    {
        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
                $purchase = PurchaseOrder::find($id);
                break;
            case TransactionEnum::purchaseInvoice->value:
                $purchase = PurchaseInvoice::find($id);
                break;
            case TransactionEnum::expense->value:
                $purchase = ExpenseRecord::find($id);
                break;
            case TransactionEnum::poAsset->value:
                $purchase = PurchaseAssetOrder::find($id);
                break;
            case TransactionEnum::purchaseAsset->value:
                $purchase = PurchaseAssetInvoice::find($id);
                break;
            default:
                break;
        }

        if (!$purchase)
            $purchase = new PurchaseOrder();

        $purchase->reference = 'REF12345678';
        $purchase->doc_number = 'PO-20240600001';
        return $purchase;
    }

    public function getTabs($id, $trxType)
    {
        return ['home' => 'Home', 'comment' => 'Comment', 'history' => 'History'];
    }

    public function getItems($id, $trxType)
    {
        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
                $items = PurchaseOrderItem::where('purchase_order_id',$id)->get()->toArray();
                break;
            case TransactionEnum::purchaseInvoice->value:
                $items = PurchaseInvoiceItem::where('purchase_invoice_id',$id)->get()->toArray();
                break;
            case TransactionEnum::expense->value:
                $items = ExpenseRecordItem::where('expense_record_id',$id)->get()->toArray();
                break;
            case TransactionEnum::poAsset->value:
                $items = PurchaseAssetOrderItem::where('purchase_asset_order_id',$id)->get()->toArray();
                break;
            case TransactionEnum::purchaseAsset->value:
                $items = PurchaseAssetInvoiceItem::where('purchase_asset_invoice_id',$id)->get()->toArray();
                break;
            default:
                break;
        }

        $items = [
            [
                'line_item_no' => 1,
                'code' => 'P00117',
                'name' => 'Timemore C3',
                'account_code' => '114102',
                'qty' => 1,
                'price' => 1560.00,
                'discount' => 0,
                'vat_rate' => 7,
                'vat_amt' =>  109.2,
                'wht_rate' => 3,
                'wht_amt' => 46.8,
                'pre_vat_amt' => 1457.94,
                'description' => 'Coffee Grinder เครื่องบดกาแฟ) - C3 Black',
            ],
            [
                'line_item_no' => 2,
                'code' => 'P00100',
                'name' => 'Timemore Filter Paper 01',
                'account_code' => '114102',
                'qty' => 1,
                'price' => 200.00,
                'discount' => 0,
                'vat_rate' => 7,
                'vat_amt' =>  14.00,
                'wht_rate' => 0,
                'wht_amt' => 0,
                'pre_vat_amt' => 186.92,
                'description' => '(Pour Over) 100Pcs',
            ],
        ];

        return $items;
    }

    public function getHistory($id, $trxType)
    {
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

        return $histories;
    }

    /**
     * merge summary and data
     */
    private function summary($summary, $data)
    {
        $summary = (array)json_decode($summary);
        $data = array_merge($data, $summary);
        $data['created_by'] = $this->authuser()->firstname;
        $data['company_id'] = 1;

        return $data;
    }

    /**
     * create/update quotation item
     */
    private function setItems($items, $id)
    {
        $items = json_decode($items);
        $oldItemCode = [];
        $oldItems = $this->getOldItems($id);

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
                if (in_array($item->code, $oldItemCode)) {
                    $this->updateItems($item, $id);
                } else {
                    $this->setNewItems($item, $id);
                }
            }
        }
    }

    private function getOldItems($id)
    {
        switch ($this->trxType) {
            case TransactionEnum::purchaseOrder->value:
                $oldItems = PurchaseOrderItem::where('purchase_order_id', $id)->get();
                break;
            case TransactionEnum::purchaseInvoice->value:
                $oldItems = PurchaseOrderItem::where('purchase_invoice_id', $id)->get();
                break;
            case TransactionEnum::expense->value:
                $oldItems = PurchaseOrderItem::where('expense_record_id', $id)->get();
                break;
            case TransactionEnum::poAsset->value:
                $oldItems = PurchaseOrderItem::where('purchase_asset_order_id', $id)->get();
                break;
            case TransactionEnum::purchaseAsset->value:
                $oldItems = PurchaseOrderItem::where('purchase_asset_invoice_id', $id)->get();
                break;
            default:
                break;
        }
        return $oldItems;
    }

    private function updateItems($item, $id)
    {
        switch ($this->trxType) {
            case TransactionEnum::purchaseOrder->value:
                PurchaseOrderItem::where([['purchase_order_id', $id], ['code', $item->code]])->update((array)$item);
                break;
            case TransactionEnum::purchaseInvoice->value:
                PurchaseOrderItem::where([['purchase_invoice_id', $id], ['code', $item->code]])->update((array)$item);
                break;
            case TransactionEnum::expense->value:
                PurchaseOrderItem::where([['expense_record_id', $id], ['code', $item->code]])->update((array)$item);
                break;
            case TransactionEnum::poAsset->value:
                PurchaseOrderItem::where([['purchase_asset_order_id', $id], ['code', $item->code]])->update((array)$item);
                break;
            case TransactionEnum::purchaseAsset->value:
                PurchaseOrderItem::where([['purchase_asset_invoice_id', $id], ['code', $item->code]])->update((array)$item);
                break;
            default:
                break;
        }
    }

    private function setNewItems($item, $id)
    {
        switch ($this->trxType) {
            case TransactionEnum::purchaseOrder->value:
                $item->purchase_order_id = $id;
                PurchaseOrderItem::create((array)$item);
                break;
            case TransactionEnum::purchaseInvoice->value:
                $item->purchase_invoice_id = $id;
                PurchaseInvoice::create((array)$item);
                break;
            case TransactionEnum::expense->value:
                $item->expense_record_id = $id;
                ExpenseRecord::create((array)$item);
                break;
            case TransactionEnum::poAsset->value:
                $item->purchase_asset_order_id = $id;
                PurchaseAssetOrder::create((array)$item);
                break;
            case TransactionEnum::purchaseAsset->value:
                $item->purchase_asset_invoice_id = $id;
                PurchaseAssetInvoice::create((array)$item);
                break;
            default:
                break;
        }
    }

    public function delete($id, $trxType)
    {
        switch ($trxType) {
            case TransactionEnum::purchaseOrder->value:
                PurchaseOrder::whereId($id)->update([
                    'is_active' => false
                ]);
                break;
            case TransactionEnum::purchaseInvoice->value:
                PurchaseInvoice::whereId($id)->update([
                    'is_active' => false
                ]);
                break;
            case TransactionEnum::expense->value:
                ExpenseRecord::whereId($id)->update([
                    'is_active' => false
                ]);
                break;
            case TransactionEnum::poAsset->value:
                PurchaseAssetOrder::whereId($id)->update([
                    'is_active' => false
                ]);
                break;
            case TransactionEnum::purchaseAsset->value:
                PurchaseAssetInvoice::whereId($id)->update([
                    'is_active' => false
                ]);
                break;
            default:
                break;
        }
    }
}
