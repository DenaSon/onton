<?php

namespace App\Livewire\UserDashboard\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Lazy]
#[Layout('components.layouts.user-dashboard')]
#[Title('Profile Settings')]
class EditProfile extends Component
{
    use Toast;

    public $name;
    public $password;
    public $password_confirmation;
    public $current_password;

    public function mount()
    {
        $this->name = auth()->user()->name;
    }

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if (!empty($this->password)) {
            $rules['password'] = ['nullable', Password::defaults(), 'confirmed'];
            $rules['current_password'] = ['required', 'current_password'];
        }

        return $rules;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        $user->name = $this->name;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->success('Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.user-dashboard.profile.edit-profile');
    }
}
