@include('pages.head')
<body>
<div class="log-form">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <h2 class="text-center">{{ __('Login') }}</h2>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-paper-plane"></i>
                    </span>
                </div>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        @if(session('message'))
            <div class="alert alert-info">
                {{session('message')}}
            </div>
        @endif
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
        </div>

        <div class="clearfix">
            <span class="pull-left checkbox-inline">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember me') }}
                </label>
            </span>

            @if (Route::has('password.request'))
                <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>
    </form>
    <div class="text-center small">Don't have an account! <a href="{{ route('register') }}">Register here</a>.</div>
</div>
</body>
</html>
