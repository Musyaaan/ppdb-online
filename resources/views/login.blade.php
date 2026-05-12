@extends('layouts.app')

@section('title', 'Login - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

    <div class="auth-wrapper">
        <div class="auth-card">

            <div class="auth-logo">
                <img src="{{ asset('image/Logo2.jpeg') }}" alt="Logo SD Negeri Legok III">
            </div>

            <h1 class="auth-card-title">Masuk</h1>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">
                        Email
                    </label>

                    <input class="form-input @error('email') is-invalid @enderror" id="email" type="email" name="email"
                        value="{{ old('email') }}" placeholder="Masukkan email anda" required autofocus
                        autocomplete="email">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">

                    <label class="form-label" for="password">
                        Kata Sandi
                    </label>

                    <div class="password-wrapper">

                        <input class="form-input @error('password') is-invalid @enderror" id="password" type="password"
                            name="password" placeholder="******" required autocomplete="current-password">

                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>

                    </div>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-row-between">
                    <div class="form-check">
                        <input type="checkbox" id="remember_me" name="remember">

                        <label for="remember_me">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    Masuk
                </button>
            </form>

            <div class="auth-links">

                <a href="{{ route('forgot-password') }}" class="link-forgot">
                    Lupa Kata Sandi?
                </a>

                <div class="auth-register">
                    Belum punya akun?
                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </div>

                <a href="{{ route('home') }}" class="auth-home-link">
                    Kembali ke Beranda
                </a>
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} SD Negeri Legok III. All rights reserved.</p>
                </div>
            </div>

        </div>
    </div>
    <script>
    function togglePassword(id, element) {

        const input = document.getElementById(id);
        const icon = element.querySelector('i');

        if (input.type === "password") {

            input.type = "text";

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = "password";

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection