<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\UserCreated;
use DB;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;

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
    protected $redirectTo = '/';

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
        return Validator::make($data, [

            'email' => 'required|email|max:255|unique:users|email_domain:' . $data['email'],
            'password' => 'required|min:6|confirmed',
            'type_id' => 'required|integer',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|min:13|max:14',
            'birthday' => 'required|date'
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
        /*Mail::send('welcome', ['mail' => $data['email']], function($message)
        {
            $message->to('mail', 'John Smith')->subject('Welcome!');
        });*/


        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type_id' => $data['type_id'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'phone' => $data['phone'],
            'birthday' => $data['birthday'],
            'email_token' => str_random(10),
        ]);




    }

    public function register(Request $request)
    {
        // Laravel validation
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            $this->throwValidationException($request, $validator);
        }
        // Using database transactions is useful here because stuff happening is actually a transaction
        // I don't know what I said in the last line! Weird!
        DB::beginTransaction();
        try
        {
            $user = $this->create($request->all());
            // After creating the user send an email with the random token generated in the create method above
            $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $user->name]));
            Mail::to($user->email)->send($email);
            DB::commit();
            //return back();
            //return redirect('login');
            return redirect('login')
                ->with('redirect', "Utente creato, controlli le sue mail per confermarlo.");
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

    public function verify($token)
    {
        // The verified method has been added to the user model and chained here
        // for better readability
        User::where('email_token',$token)->firstOrFail()->verified();
        return redirect('login');
    }
}
