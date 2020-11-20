<footer class="footer">
    <div class="footer__left">
        <p class="footer__footnote">
            Website design &copy; 2020 <a class="footer__link" href="https://gstill.dev" target="_blank" rel="noopener noreferrer">Graham Still</a>
        </p>

        <p class="footer__footnote">
            Entypo pictograms by Daniel Bruce — <a class="footer__link" href="https://www.entypo.com" target="_blank" rel="noopener noreferrer">www.entypo.com</a>
        </p>
    </div>

    <div class="footer__right">
        <ul class="footer__links">
            <li class="footer__link-item">
                @auth
                    <form
                        x-data
                        x-ref="logoutForm"
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf
                        <a
                            class="footer__link"
                            href="{{ route('logout') }}"
                            @click.prevent="$refs.logoutForm.submit()"
                        >
                            Sign out
                        </a>
                    </form>
                @else
                    <button
                        x-data
                        class="footer__link"
                        @click.prevent="$dispatch('prompt-login')"
                    >
                        Sign in
                    </button>
                @endauth
            </li>
        </ul>
    </div>
</footer>

@push('modals')
    @include('components.modals.sign-in')
@endpush
