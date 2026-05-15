@extends('layouts.app')

@section('title', 'Register akun - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="{{ asset('image/Logo2.jpeg') }}" alt="Logo SD Negeri Legok III">
            </div>
            <h1 class="auth-card-title">Buat Akun</h1>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input class="form-input @error('name') is-invalid @enderror" id="name" type="text" name="name"
                        value="{{ old('name') }}" placeholder="Masukkan nama orang tua calon peserta didik" required
                        autofocus autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-input @error('username') is-invalid @enderror" id="username" type="text"
                        name="username" value="{{ old('username') }}" placeholder="Buat username untuk login" required
                        autocomplete="username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-input @error('email') is-invalid @enderror" id="email" type="email" name="email"
                        value="{{ old('email') }}" placeholder="Isi email pribadi anda" required autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No Handphone --}}
                <div class="form-group">
                    <label class="form-label" for="phone">No. Handphone</label>
                    <input class="form-input @error('phone') is-invalid @enderror" id="phone" type="tel" name="phone"
                        value="{{ old('phone') }}" placeholder="Contoh: 08123456789" required autocomplete="tel">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="password-wrapper">
                        <input class="form-input @error('password') is-invalid @enderror" id="password" type="password"
                            name="password" placeholder="Min. 8 karakter" required autocomplete="new-password">
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="password-wrapper">
                        <input class="form-input" id="password_confirmation" type="password" name="password_confirmation"
                            placeholder="Ulangi kata sandi" required autocomplete="new-password">
                        <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
            <a href="{{ route('home') }}" class="auth-home-link">
                Kembali ke Beranda
            </a>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} SD Negeri Legok III. All rights reserved.</p>
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