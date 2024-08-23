<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\CategoryBusiness;
use App\Models\Company;
use App\Models\SettingDocType;
use App\Models\SettingDueDate;
use App\Models\SettingOther;
use App\Models\SettingPayment;
use Google\Rpc\Context\AttributeContext\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        //pattern
        $config = [
            'table' => 'users',
            'field' => 'user_code',
            'length' => 10,
            'prefix' => 'EM' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];

        $config_company = [
            'table' => 'companies',
            'field' => 'company_code',
            'length' => 10,
            'prefix' => 'CM' . date('Y') . date('m'),
            'reset_on_prefix_change' => true,
        ];

        $user_code = IdGenerator::generate($config);
        $company_code = IdGenerator::generate($config_company);

        $company = new Company();
        $company->company_code = $company_code;
        $company->tax_number = $data['tax_id'];
        $company->name_th = $data['company_name'];
        $company->category_business_id = $data['juristic_person'];
        $company->branch = $data['branch_check'];
        $company->branch_no = $data['branch_number'];
        $company->type_registration = $data['organization_info_chkbox'];

        if ($company->save()) {
            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'user_code' => $user_code,
                'email' => $data['email'],
                'company_id' =>  $company->id,
                'password' => Hash::make($data['password']),
            ])->assignRole('admin');

            $doc_types = [
                ["header" => "QO", "account_type" => "1"],
                ["header" => "TDN", "account_type" => "1"],
                ["header" => "IV", "account_type" => "1"],
                ["header" => "IVT", "account_type" => "1"],
                ["header" => "DN", "account_type" => "1"],
                ["header" => "RE", "account_type" => "1"],
                ["header" => "RT", "account_type" => "1"],
                ["header" => "TIV", "account_type" => "1"],
                ["header" => "CN", "account_type" => "1"],
                ["header" => "CNT", "account_type" => "1"],
                ["header" => "BN", "account_type" => "1"],
                ["header" => "DBN", "account_type" => "1"],
                ["header" => "DBNT", "account_type" => "1"],
                ["header" => "PO", "account_type" => "2"],
                ["header" => "POA", "account_type" => "2"],
                ["header" => "PR", "account_type" => "2"],
                ["header" => "EXP", "account_type" => "2"],
                ["header" => "CNX", "account_type" => "2"],
                ["header" => "CPN", "account_type" => "2"],
                ["header" => "PA", "account_type" => "2"]
            ];

            foreach ($doc_types as $key => $value) {
                $create_doc_type = new SettingDocType();
                $create_doc_type->header = $value['header'];
                $create_doc_type->doc_type = $key + 1;
                $create_doc_type->account_type = $value['account_type'];
                $create_doc_type->company_id = $company->id;
                $create_doc_type->save();
            }

            for ($i = 1; $i <= 6; $i++) {
                $create_due_date = new SettingDueDate();
                $create_due_date->doc_type = $i;
                $create_due_date->account_type = $i <= 3 ? 1 : 2;
                $create_due_date->company_id = $company->id;
                $create_due_date->save();
            }

            $create_others = new SettingOther();
            $create_others->company_id = $company->id;
            $create_others->save();

            $create_payment = new SettingPayment();
            $create_payment->company_id = $company->id;
            $create_payment->save();
        }

        toast('สมัครสมาชิกสำเร็จ', 'success')->autoClose(1500);
        return $user;
    }
}
