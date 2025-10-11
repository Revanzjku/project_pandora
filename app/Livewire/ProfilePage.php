<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class ProfilePage extends Component
{
    // Profile Information
    public $name;
    public $email;

    // Password Update
    public $current_password;
    public $password;
    public $password_confirmation;

    // Delete Account
    public $delete_password;
    public $showDeleteModal = false;

    // Success messages
    public $profileSuccess = false;
    public $passwordSuccess = false;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    // Update Profile Information
    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->profileSuccess = true;
        $this->dispatch('profile-updated');
        
        // Reset success message after 3 seconds - FIXED
        $this->dispatch('reset-profile-success');
    }

    // Update Password
    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        // Reset password fields
        $this->reset(['current_password', 'password', 'password_confirmation']);
        
        $this->passwordSuccess = true;
        $this->dispatch('password-updated');
        
        // Reset success message after 3 seconds - FIXED
        $this->dispatch('reset-password-success');
    }

    // Delete Account
    public function deleteAccount()
    {
        $this->validate([
            'delete_password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    }

    // Reset success messages
    public function resetProfileSuccess()
    {
        $this->profileSuccess = false;
    }

    public function resetPasswordSuccess()
    {
        $this->passwordSuccess = false;
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}