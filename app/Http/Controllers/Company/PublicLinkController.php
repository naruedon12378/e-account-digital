<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SettingOther;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PublicLinkController extends Controller
{
    public function index(Request $request)
    {
        // $company_id = Company::where('user_id', Auth::user()->id)->pluck('id')->first();

        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            $company_doc_settings = SettingOther::where('company_id', $company_id)->select('status_signature', 'status_company_seal', 'status_doc_access_code')->first();
            return view('company.doc_setting.public_link.index', compact('company_doc_settings', 'company_id'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $inputData = $request->all();
        DB::beginTransaction();
        try {
            $update = SettingOther::where([
                ['company_id', $inputData['company_id']]
            ])->first();
            $update = SettingOther::where('company_id', $inputData['company_id'])->first()
                ->update($inputData);
            if ($update) {
                DB::commit();
                toast('บันทึกข้อมูล', 'success');
            }
            return redirect()->route('setting-public-link.index');
        } catch (\Exception $ex) {
            $result['status'] = "failed";
            $result['message'] = $ex;
            dd($ex);
            DB::rollBack();
            Alert::error('ผิดพลาด');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
