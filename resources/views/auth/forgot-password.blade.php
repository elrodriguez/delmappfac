<x-guest-layout>
    <x-slot name="header">
        <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
            Already a member?
        </span>
        <a href="{{ route('login') }}" class="btn-link text-white ml-auto ml-sm-0">
            Secure Login
        </a>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                {{ __('¿Olvidaste tu contraseña?') }}
                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </small>
            </h2>
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="col-xl-6 ml-auto mr-auto">
            <div class="card p-4 rounded-plus bg-faded">
                <x-jet-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control" placeholder="Recovery email" name="email" :value="old('email')" required autofocus>
                        <div class="invalid-feedback">No, you missed this one.</div>
                        <div class="help-block">We will email you the instructions</div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-md-4 ml-auto text-right">
                            <button id="js-login-btn" type="submit" class="btn btn-danger">{{ __('Email Password Reset Link') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
