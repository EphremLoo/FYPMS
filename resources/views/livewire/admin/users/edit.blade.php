<div>
    <x-header title="Update {{ $user->name }}" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-input label="Email" wire:model="email" />
        <x-input label="MMU ID" wire:model="mmu_id" />
        <x-password label="Password" wire:model="password" right />
        <x-password label="Confirm Password" wire:model="password_confirmation" right />
        <x-choices label="Roles" wire:model="roles" :options="$rolesArray" clearable />
        <x-select label="Status" wire:model="status" :options="$statuses" />

        <x-slot:actions>
            <x-button label="Delete" icon="o-trash" wire:click="delete({{ $user['id'] }})" wire:confirm="Are you sure?" spinner class="btn-error mr-auto" />
            <x-button label="Cancel" link="{{ route('admin.users.index') }}" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" spinner class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
