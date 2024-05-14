<x-guest-layout>
    <!-- Statut de session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Adresse e-mail -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

        </div>

        <!-- Se souvenir de moi -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __("Se souvenir de moi") }}</span>
            </label>
        </div>



            <x-primary-button class="ms-3">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>
        @if ($errors->has('email') || $errors->has('password'))
            <div class="alert alert-danger mt-4">
                {{ __("Ces identifiants ne correspondent pas à nos enregistrements.") }}
            </div>
        @endif
    </form>
</x-guest-layout>
