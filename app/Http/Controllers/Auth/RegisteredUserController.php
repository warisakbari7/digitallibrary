<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('frontend.register');
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'live_in' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users|indisposable',
            'password' => ['required','max:8', 'confirmed', Rules\Password::defaults()],
        ]);
        $name = time().rand(1,1000).date('dmy').'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('application/users'),$name);

        $user = User::create([
            'name' => ucfirst(trim($request->name)),
            'email' => trim($request->email),
            'password' => Hash::make(trim($request->password)),
            'lastname' => ucfirst(trim($request->last_name)),
            'image' => $name,
            'is_active' => true,
            'type' => 'client',
            'phone' => trim($request->phone),
            'occupation' => ucfirst(trim($request->occupation)),
            'live_in' => ucfirst(trim($request->live_in)),
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Request $request,$id)
    {
        if(Auth::user()->id == $id)
        {
            $user = User::find($id);
            $user->name = trim($request->name);
            $user->lastname = trim($request->lastname);
            $user->occupation = trim($request->occupation);
            $user->live_in = trim($request->live);
            $user->phone = \trim($request->phone);
            $user->save();
            return response()->json($request->toArray());
        }
    }

   
    public function changepassword(Request $request)
    {
       $validator = Validator::make($request->all(),[
        'old_password'=>'required',
        'password'=>['required','max:8', 'confirmed', Rules\Password::defaults()],
       ]);
       if($validator->fails())
       {
           return response()->json(['errors'=>$validator->errors()]);
       }
       else
       {
           $oldpassword = Auth::user()->password;
           if(Hash::check($request->old_password,$oldpassword))
            {
                Auth::user()->password = Hash::make($request->password);
                Auth::user()->save();
            }
            else
            {
                return response()->json(['msg'=>'The old password did not match']);
            }
       }
    }

}
