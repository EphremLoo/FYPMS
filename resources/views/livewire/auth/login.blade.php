<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10">
        <x-app-brand />
    </div>

    <x-form wire:submit="login">
        <x-input Label="E-mail" placeholder="E-mail" wire:model="email" icon="o-envelope" />
        <x-input Label="Password" placeholder="Password" wire:model="password" type="password" icon="o-key" />

        <x-slot:actions>
            <x-button label="Register" class="btn-ghost" link="/register" />
            <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>
