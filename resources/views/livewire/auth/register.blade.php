<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10">
        <x-app-brand />
    </div>

    <x-form wire:submit="register">
        <x-input label="Name" wire:model="name" />
        <x-input label="Email" placeholder="E-mail" wire:model="email" icon="o-envelope" />
        <x-input label="MMU ID" wire:model="mmu_id" />
        <x-password label="Password" wire:model="password" right />
        <x-password label="Confirm Password" wire:model="password_confirmation" right />

        <x-slot:actions>
            <x-button label="Login" class="btn-ghost" link="/login" />
            <x-button label="Register" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="register" />
        </x-slot:actions>
    </x-form>
</div>
