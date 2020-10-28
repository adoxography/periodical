<x-app-layout>
    <div class="tabs" x-data="{ tab: 'account' }">
        @can ('alter site settings')
            <div class="tabs__navigation">
                <a
                    class="tabs__label"
                    :class="{ 'tabs__label--active': tab === 'account' }"
                    @click.prevent="tab = 'account'"
                    href="#"
                >
                    Account settings
                </a>

                <a
                    class="tabs__label"
                    :class="{ 'tabs__label--active': tab === 'site' }"
                    @click.prevent="tab = 'site'"
                    href="#"
                >
                    Site settings
                </a>
            </div>
        @endcan

        <div class="tabs__content settings" x-show="tab === 'account'">
            <h2 class="settings__title">
                Account settings
            </h2>

            <livewire:user-settings :user="Auth::user()" />
        </div>

        @can ('alter site settings')
            <div class="tabs__content settings" x-show="tab === 'site'">
                <h2 class="settings__title">
                    Site settings
                </h2>

                <livewire:site-settings />
            </div>
        @endcan
    </div>
</x-app-layout>
