@include('pages.head')
<body>
<div class="log-form">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <h2 class="text-center">{{ __('Register') }}</h2>
        <p class="small">Please fill in this form to create an account!</p>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Username') }}" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
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
                        <i class="fas fa-paper-plane"></i>
                    </span>
                </div>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" value="{{ old('email') }}" required autocomplete="email">
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
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                @error('password')
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
                        <i class="fas fa-check"></i>
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
            </div>
        </div>
        @if(session('message'))
            <div class="alert alert-info">
                {{session('message')}}
            </div>
        @endif
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
        </div>

    </form>
    <div class="text-center small">Already have an account? <a href="{{ route('login') }}">Login here</a></div>
</div>
</body>
</html>
