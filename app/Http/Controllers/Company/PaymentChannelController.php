<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\SettingOther;
use App\Models\SettingPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentChannelController extends Controller
{
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            $locale = app()->getLocale();
            $company_doc_settings = SettingPayment::where('company_id', $company_id)->select('*')->first();
            $img = "";
            if ($company_doc_settings->getFirstMediaUrl('payment_channel')) {
                $img = $company_doc_settings->getFirstMediaUrl('payment_channel');
            } else {
                $img = asset('images/no-image.jpg');
            }
            $getBanks = BankAccount::where([['company_id', $company_id], ['financial_type', 2]])->with('bank')->get();
            $allBanks = Bank::where('publish', 1)->get()->sortBy('sort');
            $banks = [];
            foreach ($getBanks as $key => $data) {
                $id = $data->id;
                $acc_type = [
                    '1' => __("payment.account_type1"),
                    '2' => __("payment.account_type2"),
                    '3' => __("payment.account_type3"),
                ];
                $name = $data['bank']['name_' . $locale] . " " . $acc_type[$data['account_type']] . " " . $data['account_number'] . " " . $data['account_name'];
                $banks[$key]['id'] = $id;
                $banks[$key]['name'] = $name;
                $banks[$key]['image'] = $data['bank']['image'];
            }
            return view('company.doc_setting.payment_channel.index', compact('company_doc_settings', 'company_id', 'img', 'banks', 'allBanks'));
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
            $getData = SettingPayment::where([
                ['company_id', $inputData['company_id']]
            ])->first();
            $update = $getData->update($inputData);
            if ($update) {
                if ($request->file('image')) {
                    $medias = $getData->getMedia('payment_channel');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('image');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('image')->getClientOriginalName();


                    $getData->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('payment_channel');
                }
                DB::commit();
                toast('บันทึกข้อมูล', 'success');
            }
            return redirect()->route('setting-payment-channel.index');
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
        // $inputData = $request->all();
        // DB::beginTransaction();
        // try {
        //     $insert = SettingPayment::create($inputData);
        //     if ($insert) {
        //         if ($request->file('img')) {
        //             $medias = $insert->getMedia('payment_channel');
        //             if (count($medias) > 0) {
        //                 foreach ($medias as $media) {
        //                     $media->delete();
        //                 }
        //             }

        //             $getImage = $request->img;
        //             $path = storage_path('app/public');
        //             if (!file_exists($path)) {
        //                 mkdir($path, 0777, true);
        //             }
        //             $insert->addMedia(storage_path('app/public') . '/' . $getImage->getClientOriginalName())->toMediaCollection('payment_channel');
        //         }
        //         DB::commit();
        //         toast('บันทึกข้อมูล', 'success');
        //     }
        //     return redirect()->route('setting-payment-channel.index');
        // } catch (\Exception $ex) {
        //     $result['status'] = "failed";
        //     $result['message'] = $ex;
        //     dd($ex);
        //     DB::rollBack();
        //     Alert::error('ผิดพลาด');
        //     return redirect()->back();
        // }
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
        $data = SettingPayment::whereId($id)->first();
        $image = $data->getFirstMediaUrl('payment_channel');

        return response()->json(['data' => $data, 'image' => $image]);
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
