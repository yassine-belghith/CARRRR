<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        
        if ($validator->fails()) {
            return view('register', [
                'error' => true,
                'nameError' => $validator->errors()->first('name'),
                'emailError' => $validator->errors()->first('email'),
                'passwordError' => $validator->errors()->first('password'),
            ]);
        }        

        // Création d'un nouvel utilisateur dans la base de données
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('page.login')->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->route('car.acceuil')->with('success', 'Connexion réussie.');
        }

        return redirect()->route('page.login')->with('error', 'E-mail ou mot de passe incorrect.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('car.acceuil')->with('success', 'Vous avez été déconnecté.');
    }

    public function users()
    {
        $users = User::paginate(15); // Récupère tous les utilisateurs

        return view('dashboard.users', ['users' => $users]); // Envoie les utilisateurs à la vue
    }

    /**
     * Make a user admin
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'Les droits d\'administrateur ont été attribués avec succès.');
    }

    /**
     * Remove admin rights from a user
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent removing admin rights from the last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('dashboard.users.index')
                ->with('error', 'Impossible de retirer les droits d\'administrateur. Il doit y avoir au moins un administrateur.');
        }
        
        $user->role = 'user';
        $user->save();

        return redirect()->route('dashboard.users.index')
            ->with('success', 'Les droits d\'administrateur ont été retirés avec succès.');
    }
    
    /**
     * Make a user a driver
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeDriver($id)
    {
        $user = User::findOrFail($id);
        $user->is_driver = true;
        $user->save();
        $user->update(['is_driver' => true]);

        return redirect()->route('dashboard.users')->with('success', 'Utilisateur défini comme chauffeur avec succès!');
    }

    public function removeDriver($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_driver' => false]);

        return redirect()->route('dashboard.users')->with('success', 'Le statut de chauffeur a été retiré à l\'utilisateur avec succès!');
    }
    
    /**
     * Show the rentals for a specific user
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function rentals(User $user)
    {
        $user->load('rentals.car');
              $rentals = $user->rentals;

        $locations = $user->locations;

        return view('users.rentals', [
            'user' => $user,
            'rentals' => $user->rentals()->with('car')->latest()->paginate(10),
            'locations' => $locations
        ]);
    }

    /**
     * Met à jour les préférences du profil utilisateur (nom, email, mot de passe, avatar)
     */
    /**
     * Affiche le formulaire de profil utilisateur
     */
    public function profile()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**
     * Met à jour les informations du profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }
        
        $user->save();

        return redirect()->route('profile.show')
                         ->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Affiche le formulaire des préférences utilisateur
     */
    public function showPreferences()
    {
        $user = auth()->user();
        return view('preferences.show', compact('user'));
    }

    /**
     * Met à jour les préférences du profil utilisateur
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'theme' => 'required|in:light,dark,system',
            'language' => 'required|in:fr,en',
        ];

        // Ajouter les règles de validation pour le mot de passe uniquement si un nouveau mot de passe est fourni
        if ($request->filled('new_password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['new_password'] = ['required', 'string', 'min:8', 'confirmed', 'different:current_password'];
        }

        $validated = $request->validate($rules, [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'new_password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas.',
            'new_password.different' => 'Le nouveau mot de passe doit être différent de l\'actuel.',
        ]);

        try {
            DB::beginTransaction();
            
            // Mise à jour du thème et de la langue
            $user->theme = $validated['theme'];
            $user->language = $validated['language'];
            
            // Mise à jour du mot de passe si fourni
            if (isset($validated['new_password'])) {
                $user->password = Hash::make($validated['new_password']);
                $passwordUpdated = true;
            }
            
            $user->save();
            DB::commit();

            $message = 'Préférences mises à jour avec succès' . (isset($passwordUpdated) ? ' et mot de passe modifié.' : '.');
            
            return redirect()
                ->route('preferences.show')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur mise à jour des préférences: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour des préférences: ' . $e->getMessage());
        }
    }
    
    /**
     * Met à jour l'avatar de l'utilisateur
     */
    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            ]);
            
            $user = Auth::user();
            
            DB::beginTransaction();
            
            // Ensure the avatars directory exists
            if (!Storage::disk('public')->exists('avatars')) {
                Storage::disk('public')->makeDirectory('avatars', 0755, true);
            }
            
            // Delete old avatar if it exists
            if ($user->avatar) {
                $oldPath = 'public/' . ltrim($user->avatar, '/');
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            
            // Store the new avatar
            $file = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/avatars', $filename);
            
            // Update user record with the relative path (without 'public/' prefix)
            $relativePath = str_replace('public/', '', $path);
            $user->avatar = $relativePath;
            $user->save();
            
            DB::commit();
            
            // Generate the full URL to the stored file
            $avatarUrl = asset('storage/' . $relativePath);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'avatar_url' => $avatarUrl,
                    'message' => 'Photo de profil mise à jour avec succès',
                    'debug' => [
                        'path' => $path,
                        'relative_path' => $relativePath,
                        'avatar_url' => $avatarUrl,
                        'storage_path' => storage_path('app/public/avatars/' . $filename),
                        'public_path' => public_path('storage/avatars/' . $filename)
                    ]
                ]);
            }
            
            return redirect()->back()->with([
                'success' => 'Photo de profil mise à jour avec succès',
                'avatar_url' => $avatarUrl
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur mise à jour avatar: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors du téléchargement de l\'image: ' . $e->getMessage(),
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors du téléchargement de l\'image: ' . $e->getMessage());
        }
    }
    
    /**
     * Supprime l'avatar de l'utilisateur
     */
    public function removeAvatar()
    {
        try {
            $user = Auth::user();
            
            if (!$user->avatar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune photo de profil à supprimer.'
                ], 400);
            }
            
            DB::beginTransaction();
            
            // Delete the avatar file
            $oldPath = 'public/' . $user->avatar;
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
            
            // Update user record
            $user->avatar = null;
            $user->save();
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Photo de profil supprimée avec succès'
                ]);
            }
            
            return redirect()->back()->with('success', 'Photo de profil supprimée avec succès');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur suppression avatar: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la suppression de la photo de profil: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de la photo de profil');
        }
    }
}
