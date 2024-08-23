<?php

namespace App\Http\Controllers\Company;

use App\Helpers\UniversalHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryBusiness;
use App\Models\Company;
use App\Models\CompanyAddress;
use App\Models\SettingDocType;
use App\Models\TypeBusiness;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    private $Helper;
    public function __construct()
    {
        $this->Helper = new UniversalHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        if (isset($company_id)) {
            $data = Company::with('company_address')
                ->where('id', $company_id)
                ->select(
                    'id',
                    'tax_number',
                    'name_th',
                    'name_en',
                    'branch',
                    'branch_no',
                    'branch_name',
                    'phone',
                    'fax_number',
                    'email',
                    'website',
                    'type_business_id',
                    'category_business_id',
                )
                ->first();
            $logo = "https://placehold.co/500x500";
            if ($data->hasMedia('company_logo')) {
                $logo = $data->getFirstMedia('company_logo')->getUrl();
            }
            $stamp = "https://placehold.co/500x500";
            if ($data->hasMedia('company_stamp')) {
                $stamp = $data->getFirstMedia('company_stamp')->getUrl();
            }
            $type_businesses = TypeBusiness::where('publish', 1)->get();
            $category_businesses = CategoryBusiness::where('publish', 1)->get();
            return view('company.setting.index', compact('data', 'type_businesses', 'category_businesses', 'logo', 'stamp', 'company_id'));
        } else {
            Alert::error('ไม่พบบริษัทของท่าน');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputData = $request->all();
        DB::beginTransaction();
        try {
            $update = Company::where([
                ['id', $inputData['id']]
            ])->first();
            $update->tax_number = $inputData['tax_number'];
            $update->category_business_id = $inputData['category_business_id'];
            $update->type_business_id = $inputData['type_business_id'];
            $update->name_th = $inputData['name_th'];
            $update->name_en = $inputData['name_en'];
            $update->branch = $inputData['branch'];
            $update->branch_name = $inputData['branch_name'];
            $update->branch_no = $inputData['branch_no'];
            $update->email = $inputData['email'];
            $update->phone = str_replace("-", "", $inputData['phone']);
            $update->fax_number = $inputData['fax_number'];
            $update->website = $inputData['website'];
            $update->vat_status = $inputData['vat_status'];
            if ($update->save()) {
                $address = CompanyAddress::where('company_id', $update->id)->first();
                $address->detail_th = $inputData['detail_th'];
                $address->sub_district_th = $inputData['sub_district_th'];
                $address->district_th = $inputData['district_th'];
                $address->province_th = $inputData['province_th'];
                $address->postcode = $inputData['postcode'];
                $address->detail_en = $inputData['detail_en'];
                $address->sub_district_en = $inputData['sub_district_en'];
                $address->district_en = $inputData['district_en'];
                $address->province_en = $inputData['province_en'];
                $address->save();

                if ($request->file('img_logo')) {
                    $medias = $update->getMedia('company_logo');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img_logo');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img_logo')->getClientOriginalName();

                    $update->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('company_logo');
                }

                if ($request->file('img_stamp')) {
                    $medias = $update->getMedia('company_stamp');
                    if (count($medias) > 0) {
                        foreach ($medias as $media) {
                            $media->delete();
                        }
                    }

                    $getImage = $request->file('img_stamp');
                    $dateTime = Carbon::now();
                    $formattedDateTime = $dateTime->format('YmdHis');
                    $newFileName = $formattedDateTime . '_' . $request->file('img_stamp')->getClientOriginalName();

                    $update->addMedia($getImage)
                        ->usingFileName($newFileName)
                        ->toMediaCollection('company_stamp');
                }
            }

            DB::commit();
            toast('บันทึกข้อมูล', 'success');
            return redirect()->route('company.index');
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
