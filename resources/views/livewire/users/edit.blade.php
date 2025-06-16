<div>
    <x-header title="Update {{ $user->name }}" separator />

    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-input label="Email" wire:model="email" />
        <x-input label="MMU ID" wire:model="mmuId" />
        <x-password label="Password" wire:model="password" right />
        <x-password label="Confirm Password" wire:model="password_confirmation" right />
        <x-choices label="Roles" wire:model="roles" :options="$rolesArray" clearable />

        <x-slot:actions>
            <x-button label="Cancel" link="/users" />
            {{-- The important thing here is `type="submit"` --}}
            {{-- The spinner property is nice! --}}
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
