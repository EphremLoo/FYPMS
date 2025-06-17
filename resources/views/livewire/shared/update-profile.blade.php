<div>
    <x-header title="Update Profile - {{ $user->name }}" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-input label="Email" wire:model="email" />
        <x-input label="MMU ID" wire:model="mmu_id" readonly/>
        <span class="text-sm text-gray-400">Note: If MMU ID is incorrect please contact admin to change it.</span>
        <x-password label="Password" wire:model="password" right />
        <x-password label="Confirm Password" wire:model="password_confirmation" right />

        <x-slot:actions>
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" spinner class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
