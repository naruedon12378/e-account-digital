<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    protected $maxAttempts = 2;
    protected $decayMinutes = 1;

    public function login(Request $request)
    {

        // if ($this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);

        //     $seconds = $this->limiter()->availableIn(
        //         $this->throttleKey($request)
        //     );

        //     return redirect('login')->with('message_wrong', trans('auth.throttle', [ 'seconds' => $seconds,'minutes' => ceil($seconds / 60),]));

        //     // return $this->sendLockoutResponse($request);
        //     // return redirect('login')->with('message_wrong',trans('auth.throttle'));
        // }

        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL);
        if (auth()->attempt(array('email' => $input['username'], 'password' => $input['password']))) {
            $this->clearLoginAttempts($request);
            if (auth()->user()->status == 1) {
                // if (auth()->user()->hasRole('user')) {
                //     Alert::success('เข้าสู่ระบบสำเร็จ');
                //     return redirect()->route('client.home');
                // }
                toast('เข้าสู่ระบบสำเร็จ','success')->autoClose(1500);
                return redirect()->route('dashboard.index');
            } else {
                //status = 0
                Auth::logout();
                // return view('auth.login');
                return redirect('login')->with('message_status', 'บัญชีผู้ใช้นี้ถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ');
            }
        }
        // $this->incrementLoginAttempts($request);
        //wrong password
        // return redirect()->route('login');
        return redirect('login')->with('message_wrong', 'ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง');
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();

        toast('ออกจากระบบสำเร็จ','success')->autoClose(1500);
        return redirect()->route('home');
    }
}