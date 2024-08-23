<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPostRequest;
use App\Models\AccountCode;
use App\Models\PrimaryAccount;
use App\Models\SecondaryAccount;
use App\Models\SubAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class ChartOfAccountController extends Controller
{
    protected $user;

    public function __construct()
    {
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
        if ($request->id) {
            $account = AccountCode::where('id', $request->id)->with('primary', 'secondary', 'subAccount')->first();
        } else {
            $account = AccountCode::with('primary', 'secondary', 'subAccount')->orderBy('id')->first();
        }
        $accountCodes = AccountCode::where('is_active', true)->get();
        $accountClasses = $this->accountClass();
        $primaries = PrimaryAccount::where('is_active', true)->orderBy('sequence')->get();

        return view('admin.chart_of_account.index', compact('accountClasses', 'account', 'accountCodes', 'primaries'));
    }

    private function accountClass()
    {
        $_classes = collect();
        $accountClasses = accountClass();
        if (count($accountClasses) > 0) {
            foreach ($accountClasses as $key => $value) {
                $_class = [
                    'name' => $value . "(" . $key . ")",
                    'primaries' => $this->primary($key),
                ];
                $_classes->push($_class);
            }
        }
        
        return $_classes;
    }

    private function primary($class)
    {
        $primaries = PrimaryAccount::where([
            ['is_active', true],
            ['account_class', $class]
        ])->orderBy('sequence')->get();

        $_primaries = collect();
        if (count($primaries) > 0) {
            foreach ($primaries as $primary) {
                $_primary = [
                    'name' => $primary->name_th . "(" . $primary->prefix . ")",
                    'secondaries' => $this->secondary($primary->id),
                ];

                $_primaries->push($_primary);
            }
        }
        return $_primaries;
    }

    private function secondary($id)
    {
        $secondaries = SecondaryAccount::where([
            ['is_active', true],
            ['primary_account_id', $id]
        ])->orderBy('sequence')->get();

        $_secondaries = collect();
        if (count($secondaries) > 0) {
            foreach ($secondaries as $secondary) {
                $_secondary = [
                    'name' => $secondary->name_th . "(" . $secondary->prefix . ")",
                    'account_codes' => $this->accountCode($secondary->id),
                ];
                $_secondaries->push($_secondary);
            }
        }
        return $_secondaries;
    }

    private function accountCode($id)
    {
        $accountCodes = AccountCode::where([
            ['is_active', true],
            ['secondary_account_id', $id]
        ])->orderBy('sub_prefix')->get();

        $_accountCodes = collect();
        if (count($accountCodes) > 0) {
            foreach ($accountCodes as $account) {
                $_accountCode = [
                    'id' => $account->id,
                    'account_code' => $account->account_code,
                    'name' => $account->name_th,
                ];
                $_accountCodes->push($_accountCode);
            }
        }
        return $_accountCodes;
    }

    public function getSecondaryById($id)
    {
        $secondaries = SecondaryAccount::where([
            ['is_active', true],
            ['primary_account_id', $id]
        ])->orderBy('sequence')->get();
        return Response::json($secondaries);
    }

    public function getSubAccById($id)
    {
        $subAccountes = SubAccount::where([
            ['is_active', true],
            ['secondary_account_id', $id]
        ])
            ->orderBy('sequence')->get();

        return Response::json($subAccountes);
    }

    public function getLastAccCode($id)
    {
        $account = AccountCode::where([
            ['is_active', true],
            ['sub_account_id', $id]
        ])->orderBy('running_number', 'desc')->first();

        if ($account)
            return Response::json($account);

        return response()->json([], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountPostRequest $request)
    {
        $data = $request->except('_token');
        $id = $request->id;
        if ($id) {
            $data['updated_by'] = $this->user->firstname;
            AccountCode::find($id)->update($data);
            Session::flash('success', 'Updated account code successfully');
        } else {
            $data['description'] = replaceRegx($data['description']);
            $data['created_by'] = $this->user->firstname;
            $data['company_id'] = $this->user->company_id;
            AccountCode::create($data);
            Session::flash('success', 'Created new account code successfully');
        }

        return Response::json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        AccountCode::find($id)->update([
            'is_active' => false,
            'updated_by' => $this->user->firstname
        ]);
        return response()->json(['status' => true, 'msg' => "Delete account code successfully."]);
    }
}
