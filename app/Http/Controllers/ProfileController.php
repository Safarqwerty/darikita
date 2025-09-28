<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
        // Start with validated data from the form request.
        // This includes all the new fields like 'tempat_lahir', 'nomor_wa', etc.
        $validatedData = $request->validated();

        // Handle the file upload for 'foto'
        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists to save space
            if ($request->user()->foto) {
                Storage::disk('public')->delete($request->user()->foto);
            }
            // Store the new photo and get its path
            $validatedData['foto'] = $request->file('foto')->store('profile-photos', 'public');
        }

        // Fill the user model with all validated data (including the new photo path if uploaded)
        $request->user()->fill($validatedData);

        // If the email address has been changed, we need to reset the verification status
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save all the changes to the database
        $request->user()->save();

        return redirect()->route('dashboard')->with('status', 'profile-updated');
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
