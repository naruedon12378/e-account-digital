<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitSetRequest;
use App\Models\ProductType;
use App\Models\Unit;
use App\Models\UnitSet;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UnitSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];
        if ($request->ajax()) {

            $data = UnitSet::myCompany()
                ->where('unit_parent_id', null)
                ->with('unit')
                ->withCount('children')
                ->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return $data->btnEdit. ' ' .$data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['action', 'isActive'])
                ->make(true);
        }
        return view('admin.unit_set.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $unit_set = [];
        $unit_parent_id = null;
        $selected_units = null;
        $unit_amounts = [];

        $units = Unit::myCompany()
            ->where('is_active', true)
            ->get();

        $action = 'create';
        $form_action = route('unitset.store');

        return view('admin.unit_set.edit', compact('action', 'form_action', 'units', 'unit_set', 'unit_parent_id', 'selected_units', 'unit_amounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitSetRequest $request)
    {
        return $this->_storeOrUpdate($request, null);
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

        $unit_parent_id = null;
        $selected_units = [];
        $unit_amounts = [];

        $units = Unit::myCompany()
            ->where('is_active', true)
            ->get();

        $unit_set = UnitSet::myCompany()
            ->where('id', $id)
            ->where('is_active', true)
            ->with('unit')
            ->with('children')
            ->first();

        if( !empty($unit_set) ){

            $unit_parent_id = $unit_set->unit_id;

            foreach($unit_set->children as $unit_child){
                $selected_units[] = $unit_child->unit_id;
                $unit_amounts[] = $unit_child->amount;
            }
        }

        $action = 'edit';
        $form_action = route('unitset.update', ['unitset' => $id]);

        return view('admin.unit_set.edit', compact('action', 'form_action', 'units', 'unit_set', 'unit_parent_id', 'selected_units', 'unit_amounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitSetRequest $request, $id)
    {
        return $this->_storeOrUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $status = false;
    //     $msg = 'ผิดพลาด';
    //     $product_type = ProductType::whereId($id)->first();
    //     if ($product_type->delete()) {
    //         $status = true;
    //         $msg = 'เสร็จสิ้น';
    //     }
    //     return response()->json(['status' => $status, 'msg' => $msg]);
    // }

    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product_type = ProductType::find($id);
        if ( !empty( $product_type) ) {
            $product_type->is_active = !$product_type->is_active;
            $product_type->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }

    public function _storeOrUpdate($request, $id)
    {
        // $data = $request->except('_token');
        $unit_parent_id = $request->unit_parent_id;
        $status = false;
        $msg = "";
        $process = 'create';

        try{

            $unit_set_id_deletes = [];

            if( !empty($id) ){

                $unit_set = UnitSet::myCompany()
                    ->where('id', $id)
                    ->first();

                $unit_set_id_deletes = UnitSet::myCompany()
                    ->where('unit_parent_id', $unit_set->unit_id)
                    ->pluck('id')
                    ->toArray();

                if( $unit_set->unit_id != $unit_parent_id ){
                    $unit_set->unit_id = $unit_parent_id;
                    $unit_set->save();
                }

                $process = 'edit';
            }else{
                $unit_set = new UnitSet();
                $unit_set->company_id =  Auth::user()->company_id;
                $unit_set->unit_parent_id =  null;
                $unit_set->unit_id =  $unit_parent_id;
                $unit_set->is_active = true;
                $unit_set->amount = 1;
                $unit_set->save();
            }

            foreach( $request->selected_units as $index => $unit_id){

                $unit_set = UnitSet::myCompany()
                    ->where('unit_parent_id', $unit_parent_id)
                    ->where('unit_id', $unit_id)
                    ->first();

                if ( !empty($unit_set) ) {
                    if( isset($unit_set_id_deletes) ){
                        if (($key = array_search($unit_set->id, $unit_set_id_deletes)) !== false) {
                            unset($unit_set_id_deletes[$key]);
                        }
                    }
                }else{
                    $unit_set = new UnitSet();
                    $unit_set->company_id =  Auth::user()->company_id;
                    $unit_set->unit_parent_id =  $unit_parent_id;
                    $unit_set->unit_id =  $unit_id;
                    $unit_set->is_active = true;
                }

                $unit_set->amount =  $request->unit_amounts[$index];
                $unit_set->save();
            }

            if( isset($unit_set_id_deletes) && count($unit_set_id_deletes) > 0){
                UnitSet::whereIn('id', $unit_set_id_deletes)->delete();
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if( $process == 'edit'){
            $message = 'แก้ไขข้อมูลเรียบร้อย';
        }else{
            $message = 'เพิ่มข้อมูลเรียบร้อย';
        }
        Session::flash('success', $message);

        // if( $status ){
            return redirect()->route('unitset.index');
        // }

        // return response()->json(['status' => $status, 'msg' => $msg]);

    }

    // public function sort($id, Request $request)
    // {
    //     $status = false;
    //     $message = 'ไม่สามารถบันทึกข้อมูลได้';

    //     $product_type = ProductType::whereId($id)->first();
    //     $product_type->sort = $request->data;
    //     $product_type->updated_at = Carbon::now();
    //     if ($product_type->save()) {
    //         $status = true;
    //         $message = 'บันทึกข้อมูลเรียบร้อย';
    //     }
    //     return response()->json(['status' => $status, 'message' => $message]);
    // }
}
