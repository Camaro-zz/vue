<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginView;
    protected $registerView;
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->loginView = config('theme.default.pages').'.auth.login';
        $this->registerView = config('theme.default.pages').'.auth.register';
    }

    protected function authenticated($request, $user){
        if ($request->has('redirectTo')){
            $this->redirectTo = $request->get('redirectTo');
        }

        return redirect()->intended($this->redirectPath());

    }

    public function showRegistrationForm(){
        $setting = Setting::first();
        if($setting['open_register'] == 0){
            return redirect()->intended($this->redirectPath());
        }
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd($data);
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->fill([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
        ]);
        $user->password = bcrypt($data['password']);

        $user->save();

        return $user;
    }

    
}
