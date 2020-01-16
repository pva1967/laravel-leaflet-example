<?php

namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
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
        $this->middleware('guest');
    }
    protected function validateEmail(Request $request)
    {

        $this->validate($request,
            [
                'email' => 'required|email|exists:users,email'
            ],
            $messages = [
                'email.required' => __('admin.email_req'),
                'email.email' =>  __('admin.email_req'),
                'exists' => __('admin.email_exists'),
            ]);
    }
}
