<?php

namespace Modules\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Action\EnvUpdateClass;
use Modules\Core\App\Emails\TestMail;
use Modules\Core\App\Http\Requests\EnvUpdateRequest;

class EnvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('core::env.updateEnv');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnvUpdateRequest $request): RedirectResponse
    {
        try {
            EnvUpdateClass::updateEnvSettings([
                // recaptcha
                'RECAPTCHA_SITE_KEY' => $request->RECAPTCHA_SITE_KEY,
                'RECAPTCHA_SECRET_KEY' => $request->RECAPTCHA_SECRET_KEY,
                'RECAPTCHA_LINK' => $request->RECAPTCHA_LINK,

                // Email
                'MAIL_MAILER' => $request->MAIL_MAILER,
                'MAIL_HOST' => $request->MAIL_HOST,
                'MAIL_PORT' => $request->MAIL_PORT,
                'MAIL_USERNAME' => $request->MAIL_USERNAME,
                'MAIL_PASSWORD' => $request->MAIL_PASSWORD,
                'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION,
                'MAIL_FROM_ADDRESS' => $request->MAIL_FROM_ADDRESS,
                'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME,

                // Firebase
                'FIREBASE_API_KEY' => $request->FIREBASE_API_KEY,
                'FIREBASE_AUTH_DOMAIN' => $request->FIREBASE_AUTH_DOMAIN,
                'FIREBASE_PROJECT_ID' => $request->FIREBASE_PROJECT_ID,
                'FIREBASE_STORAGE_BUCKET' => $request->FIREBASE_STORAGE_BUCKET,
                'FIREBASE_MESSAGING_SENDER_ID' => $request->FIREBASE_MESSAGING_SENDER_ID,
                'FIREBASE_APP_ID' => $request->FIREBASE_APP_ID,
            ]);

            return redirect()->back()->with('success', 'Environment settings updated successfully.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update environment settings: '.$e->getMessage());
        }
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            Mail::to($request->email)->send(new TestMail());
            return back()->with('success', 'Test email sent successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed: '.$e->getMessage());
        }
    }

}
