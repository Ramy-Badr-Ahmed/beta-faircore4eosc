<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify', 'serveVerificationLink');
        $this->middleware('throttle:3,1')->only('verify', 'serveVerificationLink', 'resend', 'resendVerificationLink');
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */

    public function serveVerificationLink(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()
            ->route('home')
            ->with('email-verified', 'Your email account has been verified!');
    }

#________________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @return RedirectResponse
     */

    public function resendVerificationLink(): RedirectResponse
    {
        if(Auth::user()->email_verified_at) {
            return redirect()
                ->route('home')
                ->with('email-verified', 'Your account has already been verified!');
        }

        Auth::user()->sendEmailVerificationNotification();

        return redirect()
            ->route('verification.notice')
            ->with('verification-mail-sent', 'Verification link sent!');
    }

}
