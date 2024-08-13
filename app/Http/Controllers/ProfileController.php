<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        //  

        $request->user()->fill($request->validated());

        $myUserCode       = $request->get('myUserCode');
        $myUserName          = $request->get('myUserName');
        $myUserTtdImage    = $request->get('myUserTtdImage');
        $myUserTtdImageOld    = $request->get('myUserTtdImageOld');


        $request->user()->myuser_code = $myUserCode;
        $request->user()->myuser_name = $myUserName;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Foto
        if ($request->file('myUserTtdImage')) {
            // upload photo
            $myUserTtdImage = $request->file('myUserTtdImage')->store('UserTtd');
            // delte photo
            if ($myUserTtdImageOld) {
                Storage::delete($myUserTtdImageOld);
            }
            // nama photo path
            $request->user()->myuser_ttd_image =  $myUserTtdImage;
        }
        // uploadphoto if foto false

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }








    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
