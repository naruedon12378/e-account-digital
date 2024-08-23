<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Auth;

class InventoryStock extends Model
{
    use HasFactory;
    protected $table = 'inventory_stocks';

    protected $fillable = [
        'inventory_id',
        'order_id',
        'transaction',
        'lot_number',
        'add_amount',
        'used_amount',
        'remaining_amount',
        'cost_price',
        'user_creator_id',
        'remark',
        'created_by',
        'updated_by',
    ];

    public static $relationships = array('lot', 'adjustment', 'beginning_balance', 'issue_requisition', 'issue_return_stock', 'receipt_planning', 'receive_finish_stock', 'transfer_requistion');
    // public static $relationship_items = array('lot.items', 'adjustment.items', 'quotation.items', 'beginning_balance.items', 'issue_requisition.items', 'issue_return_stock.items', 'receipt_planning.items', 'receive_finish_stock.items', 'transfer_requistion.items');
    public static $relationship_item_products = array('lot.items.product', 'adjustment.items.product', 'beginning_balance.items.product', 'issue_requisition.items.product', 'issue_return_stock.items.product', 'receipt_planning.items.product', 'receive_finish_stock.items.product', 'transfer_requistion.items.product');
    public static $relationship_users = array('lot.user_creator', 'lot.user_approver', 'adjustment.user_creator', 'adjustment.user_approver', 'beginning_balance.user_creator', 'beginning_balance.user_approver', 'issue_requisition.user_creator','issue_requisition.user_approver', 'issue_return_stock.user_creator', 'issue_return_stock.user_approver','receipt_planning.user_creator', 'receipt_planning.user_approver', 'receive_finish_stock.user_creator','receive_finish_stock.user_approver', 'transfer_requistion.user_creator','transfer_requistion.user_approver');

    public function scopeGenerateTransaction(){
        $tools_code_from_table = InventoryStock::pluck('transaction')->toArray();
        $last_code = InventoryStock::orderBy('created_at', 'desc')->first();
        $randomNumber = mt_rand(100, 999);
        $randomNumber = str_pad($randomNumber, 2, '0', STR_PAD_LEFT);
        $current_date = date('ym');
        if ($last_code) {
            $transaction_number = 'TRNS' . $current_date . $randomNumber . $last_code->id + 1;
        } else {
            $transaction_number = 'TRNS' . $current_date . $randomNumber . 1;
        }
        while (in_array($transaction_number, $tools_code_from_table)) {
            $randomNumber = mt_rand(100, 999);
            $randomNumber = str_pad($randomNumber, 2, '0', STR_PAD_LEFT);
            $transaction_number = 'TRNS' . $current_date . $randomNumber . $last_code->id + 1;
        }
        return $transaction_number;
    }

    public function scopeMyCompany($query)
    {
        return $query->whereHas('inventory', function($q){
            $q->where('company_id', Auth::user()->company_id);
        });
    }

    public function getBtnAdjustStockAttribute()
    {
        $btnAdjustStock = '';

        if(Auth::user()->hasAnyPermission(['*', 'all article', 'edit article'])){
            $btnAdjustStock = '<a class="btn btn-sm btn-warning" href="'.route('inventorystockadjustment.create',['stockId' => $this->id ]).'"><i class="fa fa-pen" data-toggle="tooltip" title="ปรับแก้สต็อค"></i> ปรับแก้สต็อค</a>';
        }

        return $btnAdjustStock;
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id')->with('warehouse');
    }

    public function order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'order_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function user_creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    // public function transaction_data()
    // {
    //     $data = null;
    //     switch($this->transaction){
    //         case 'adjustment': $data = $this->adjustment(); break;
    //         case 'quotation': $data = $this->quotation(); break;
    //         case 'beginning_balance': $data = $this->beginning_balance(); break;
    //         case 'issue_requisition': $data = $this->issue_requisition(); break;
    //         case 'reture_issue_stock': $data = $this->reture_issue_stock(); break;
    //         case 'receipt_planning': $data = $this->receipt_planning(); break;
    //         case 'receive_finish_stock': $data = $this->receive_finish_stock(); break;
    //         case 'transfer_requistion': $data = $this->transfer_requistion(); break;
    //     }
    //     dd($this->all(), $this->transaction,$data);

    //     return $data;
    // }

    public function lot()
    {
        return $this->belongsTo( InventoryLot::class, 'order_id');//->withCount('items');
    }

    public function adjustment()
    {
        return $this->belongsTo( InventoryStockAdjustment::class, 'order_id');
    }

    public function quotation()
    {
        return $this->belongsTo( Quotation::class, 'order_id');
    }

    public function beginning_balance()
    {
        return $this->belongsTo( BeginningBalance::class, 'order_id');
    }

    public function issue_requisition()
    {
        return $this->belongsTo( IssueRequisition::class, 'order_id');
    }

    public function reture_issue_stock()
    {
        return $this->belongsTo( IssueReturnStock::class, 'order_id');
    }
    public function issue_return_stock()
    {
        return $this->belongsTo( IssueReturnStock::class, 'order_id');
    }

    public function receipt_planning()
    {
        return $this->belongsTo( ReceiptPlanning::class, 'order_id');
    }

    public function receive_finish_stock()
    {
        return $this->belongsTo( ReturnFinishStock::class, 'order_id');
    }

    public function transfer_requistion()
    {
        return $this->belongsTo( ReceiptPlanningItem::class, 'order_id');
    }
}
