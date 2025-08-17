<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPreferencesController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'theme' => 'required|in:light,dark',
            'language' => 'nullable|string|max:10',
            'notifications' => 'nullable|boolean',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Préférences mises à jour avec succès.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
    }
}
