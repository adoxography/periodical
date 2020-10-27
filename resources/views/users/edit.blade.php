<x-app-layout>
    <div class="settings">
        <h2 class="settings__title">
            Settings
        </h2>

        <livewire:user-settings :user="Auth::user()" />
    </div>
</x-app-layout>
