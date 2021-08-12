<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\RTO;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     *
     * Redirect users to default application uri
     *
     * @return string
     */
    public function redirectTo()
    {
        // dd('checked');
        // SET COOKIE in SHARED INBOX
        // $uemail     = \Auth::user()->email()->first();
        // $email      = $uemail->email;
        // $password   = $uemail->email_password;

        // $cookie_name1 = "usrmail";
        // $cookie_value1 = $email;
        // $cookie_name2 = "usrpwd";
        // $cookie_value2 = $password;
        // setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/", ".eti.edu.au"); //name,value,time,url
        // setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/", ".eti.edu.au");
        if(Auth::user()){
            if(Auth::user()->is_active != 1){
                abort(404);
            }
        }
        return $this->redirectTo;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // dd($request->all());
        return ['username' => $request->username, 'password' => $request->password, 'is_active' => true];
    }

    public function userLogout()
    {
        // UNSET SHARED INBOX credentials
        unset($_COOKIE['usrmail']);
        unset($_COOKIE['usrpwd']);

        Auth::guard('web')->logout();
        
        return redirect('/login');
    }
    public function logout(){
        $role = Auth::user()->roles[0]->id;

        unset($_COOKIE['usrmail']);
        unset($_COOKIE['usrpwd']);

        Auth::guard('web')->logout();
        
        if($role==6){//student role id
            return redirect('/student-login');
        }else{
            return redirect('/login');
        }
    }
    public function check_rto($org_id)
    {

        // header("Content-Type: application/json");
        // header("Access-Control-Allow-Origin: *");

        $rto = RTO::where('organisation_id', $org_id)->first();

        if(isset($rto->id)){
            return ['status'=>1, 'url' => $rto->vorx_url];
        }else{
            return ['status'=>0, 'msg'=>'access denied'];
        }
    }

    public function centralized_login($username  = '', $password  = '')
    {
        
        try {
            //code...
            $ciphering = "AES-128-CTR"; 
            $iv_length = openssl_cipher_iv_length($ciphering); 
            $options = 0;
            $decryption_iv = '2136598457629874';
            $decryption_key = "VORXfortheWIN";
            $decryption=openssl_decrypt ($password, $ciphering, $decryption_key, $options, $decryption_iv);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect('https://vorx.com.au/login?access=0');
        }
        
        $logins = ['username'=>$username, 'password'=>$decryption];

        $request = new Request;
        $request->replace($logins);

        

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            
            
            // return $this->sendLockoutResponse($request);
        }

        // dump($request->all());

        // dd($this->guard()->attempt(
        //     $this->credentials($request), $request->filled('remember')
        // ));

        if ($this->attemptLogin($request)) {
            // dd($request->all());
            return $this->sendLoginResponse1($request);
        }else{
            // dd('ngano wala?');
            return redirect('https://vorx.com.au/login?access=0');
        }
        
        // try {
        //     //code...
        //     $this->login($request);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     dd('error');
        // }
        
        // dd('test');
        
        // return $this->redirectTo;

        
    }

    protected function sendLoginResponse1(Request $request)
    {
        // $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    public function student_login(){
        return view('auth.student-login');
    }

}
