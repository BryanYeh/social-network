<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;


class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'password' => 'required|min:4'
        ]);
        $email = $request['email'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $email->last_name = $last_name;
        $user->password = $password;

        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->intended('dashboard');
        }
        return redirect()->route('home')->withErrors($validator, 'login');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:120',
            'last_name' => 'max:120'
        ]);

        $user = Auth::user();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->update();

        $file = $request->file('image');
        $filename = $request['first_name'] . '_' . $user->id . '.jpg';
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}
