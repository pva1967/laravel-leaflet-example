<?php

namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLinkRequestForm(){
        return view('auth.passwords.email',[
            'title' => 'Admin Password Reset Notification',
            'passwordEmailRoute' => 'admin.password.email'
        ]);
    }


    protected function broker()
    {
        return Password::broker('admins');
    }
    protected function validateEmail(Request $request)
    {


        $this->validate($request,
            [
                'email' => 'required|email|exists:admins,email'
            ],
            $messages = [
                'email.required' => __('admins.email_req'),
                'email.email' =>  __('admins.email_req'),
                'exists' => __('admins.email_exists'),
            ]);
    }
}
