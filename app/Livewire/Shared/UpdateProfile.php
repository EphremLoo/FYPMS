<?php

namespace App\Livewire\Shared;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class UpdateProfile extends Component
{
    use Toast;

    public User $user;

    public string $name = '';

    public string $mmu_id = '';

    public string $email = '';

    public string $password = '';
    public string $password_confirmation = '';

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => 'nullable|confirmed',
        ];
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->fill($this->user);
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->user->update($data);
        $this->success('Profile updated with success.', redirectTo: route('profile'));
    }

    public function render()
    {
        return view('livewire.shared.update-profile');
    }
}
