<?php

namespace App\Http\Controllers\Auth;

use App\Utilities\Xat;
use App\Models\User;
use App\Utilities\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/panel/home';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|max:50|unique:users,name|alpha_num',
                'email' => 'required|email|max:50|unique:users,email',
                'regname' => 'required|max:50|unique:users,regname',
                'xatid' => 'required|integer|unique:users',
                'password' => 'required|min:6|confirmed'
            ]
        );

        $validator->after(
            function ($validator) use ($data) {

                $regname = Xat::isXatIDExist($data['xatid']);
                if (!Xat::isValidXatID($data['xatid'])) {
                    $validator->errors()->add('xatid', 'The xatid is not valid!');
                } elseif (!$regname) {
                    $validator->errors()->add('xatid', 'The xatid does not exist!');
                }

                if (!Xat::isValidRegname($data['regname'])) {
                    $validator->errors()->add('regname', 'The regname is not valid!');
                } elseif (!Xat::isRegnameExist($data['regname'])) {
                    $validator->errors()->add('regname', 'The regname does not exist!');
                }

                if (strtolower($regname) != strtolower($data['regname'])) {
                    $validator->errors()->add('regname', 'Regname and xatid do not match!');
                    $validator->errors()->add('xatid', 'Regname and xatid do not match!');
                }
            }
        );

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'xatid' => $data['xatid'],
                'regname' => $data['regname'],
                'password' => Hash::make($data['password']),
                'language_id' => 1,
                'ip' => request()->ip(),
                'share_key' => Functions::generateRandomString(60)
            ]
        );

        $user->attachRole(5);

        return $user;
    }
}
