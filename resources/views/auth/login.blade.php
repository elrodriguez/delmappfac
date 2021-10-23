<x-guest-layout>
    <x-slot name="header">
        <!--a href="page_register.html" class="btn-link text-white ml-auto">
            Create Account
        </a-->
    </x-slot>
    <div class="row">
        <div class="col col-md-6 col-lg-7 hidden-sm-down">
            <h2 class="fs-xxl fw-500 mt-4 text-white">
                Interfaz de usuario más fácil &amp; predictiva
                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                    Experimente la simplicidad del sistema {{ config('app.name', 'Laravel') }}, adaptable en cualquier dispositivo.
                </small>
            </h2>
            <!--a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a-->
            <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                    Encuéntrenos en las redes sociales
                </div>
                <div class="d-flex flex-row opacity-70">
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-google-plus-square"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
            <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                Secure login
            </h1>
            <div class="card p-4 rounded-plus bg-faded">
                <x-jet-validation-errors class="mb-4" />
                @if (session('status'))
                    <div class="alert alert-danger">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" class="form-control form-control-lg" placeholder="your id or email" name="email" :value="old('email')" required autofocus>
                        <div class="invalid-feedback">No, you missed this one.</div>
                        <div class="help-block">Your unique username to app</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <input type="password" id="password" class="form-control form-control-lg" placeholder="password" name="password" required autocomplete="current-password">
                        <div class="invalid-feedback">Sorry, you missed this one.</div>
                        <div class="help-block">Your password</div>
                    </div>
                    <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember"> {{ __('Remember me') }}</label>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        @if (Route::has('password.request'))
                        <div class="col-lg-6">
                            <a  href="{{ route('password.request') }}" class="btn btn-link">{{ __('Forgot your password?') }}</a>
                        </div>
                        @endif
                        <div class="col-lg-6 pl-lg-1 my-2">
                            <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">{{ __('Login') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
